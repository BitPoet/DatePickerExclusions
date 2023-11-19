<?php namespace ProcessWire;

class DatePickerExclusions extends WireData implements Module {

	public static function getModuleInfo() {
		return [
			'title'				=>	__('Date Picker Exclusions', __FILE__),
			'summary'			=>	__("Allow exclusions for InputfieldDateTime's date picker", __FILE__),
			'version'			=>	'0.0.3',
			'autoload'			=>	true
		];
	}
	
	
	public function init() {
		
		$this->addHookAfter('InputfieldDatetime::getConfigInputfields', $this, 'addConfigOptions');
		$this->addHookAfter('InputfieldDatetime::render', $this, 'injectScript');

	}
	
	
	public function injectScript(HookEvent $event) {

		$idt = $event->object;
		
		if($idt->inputType !== 'text' || $idt->datepicker === InputfieldDatetimeText::datepickerNo)
			return;

		$fname = $idt->attr('name');
		$f = $this->fields->get($fname);
		
		$excludeDaysOfWeek = '[' . implode(',', $f->excludeDaysOfWeek ?: []) . ']';
		$excludeDaysOfWeekText = $f->excludeDaysOfWeekText ?: '';
		$daysArray = '[' . implode(',', $this->quoteAndSplit($f->excludeDates ?: '')) . ']';
		$firstDayOfWeek = $f->firstDayOfWeek ?: 0;
		
		$script = '<script>
			$(document).ready(function() {
				$("#Inputfield_' . $fname . '").one( "focus", function( event, ui ) {
					$("#Inputfield_' . $fname . '").datepicker("option", "beforeShowDay", function(dt) {
						const excludeDaysOfWeek = ' . $excludeDaysOfWeek . ';
						const excludeDates = ' . $daysArray . ';
						var day = dt.getDay();
						if(excludeDaysOfWeek.includes(day)) {
							return [false, "", "' . $excludeDaysOfWeekText . '"];
						}
						var dateStr = $.datepicker.formatDate("yy-mm-dd", dt);
						for(var i = 0; i < excludeDates.length; i++) {
							const excludeDate = excludeDates[i];
							if(excludeDate[0] == dateStr) {
								return [false, "", excludeDate[1]];
							}
						}
						return [true, "", ""];
					});
					$("#Inputfield_' . $fname . '").datepicker("option", "firstDay", ' . $firstDayOfWeek . ');
				});
			});
		</script>';
		
		$event->return .= $script;
		
	}
	
	protected function quoteAndSplit($inp) {
		
		$inp = trim($inp);
		
		if(empty($inp))
			return [];
		
		$dates = explode(',', $inp);
		$out = [];
		
		foreach($dates as $d) {
			
			$parts = explode('=', $d);
			
			if(count($parts) < 2) {
				$text = "";
			} else {
				$text = $parts[1];
			}
			
			$d = $parts[0];
			
			$d = preg_replace('/[^0-9-]/', '', $d);
			$out[] = "['$d', '$text']";
		}
		
		return $out;
		
	}
	
	
	public function addConfigOptions(HookEvent $event) {
		
		$idt = $event->object;
		$inputfields = $event->return;
		$field = $this->fields->get($idt->attr('name'));
		
		$wrap = $this->modules->get('InputfieldFieldset');
		$wrap->attr('name', 'wrapPickerOptions');
		$wrap->label = $this->_('Datepicker Options');
		
		$f = $this->modules->get('InputfieldCheckboxes');
		$f->attr('name', 'excludeDaysOfWeek');
		$f->label = $this->_("Excluded Days of Week");
		$f->optionColumns = 1;
		foreach(range(0, 6) as $day) {
			$options = (is_array($field->excludeDaysOfWeek) && in_array($day, $field->excludeDaysOfWeek)) ? ['checked' => 'checked'] : [];
			$f->addOption($day, date('l', strtotime("Sunday +$day days")), $options);
		}
		$wrap->append($f);
		
		$f = $this->modules->get('InputfieldText');
		$f->attr('name', 'excludeDaysOfWeekText');
		$f->label = $this->_("Hover Text for Excluded Days of Week");
		$f->description = $this->_("This text will be shown when hovering over a day that was disabled above");
		$f->attr('value', $field->excludeDaysOfWeekText);
		$wrap->append($f);

		$f = $this->modules->get('InputfieldTextarea');
		$f->label = $this->_('Dates to Exclude');
		$f->description = $this->_("Enter dates in the format yyyy-mm-dd, separated by commas, e.g. 2023-11-15,2023-11-16. You can specify an optional hover text by appending that with an equal sign, e.g. 2023-10-31=Halloween");
		$f->attr('name', 'excludeDates');
		$f->attr('value', $field->excludeDates);
		$wrap->append($f);
		
		$f = $this->modules->get('InputfieldRadios');
		$f->attr('name', 'firstDayOfWeek');
		$f->label = $this->_("First Day of Week");
		$f->optionColumns = 1;
		foreach(range(0, 6) as $day) {
			$f->addOption($day, date('l', strtotime("Sunday +$day days")));
		}
		$f->attr('value', $field->firstDayOfWeek ?: 0);
		$wrap->append($f);

		$inputfields->append($wrap);
		
		$event->return = $inputfields;
		
	}
	
	
}
