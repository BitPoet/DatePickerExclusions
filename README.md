# DatePickerExclusions
ProcessWire module that makes excluded days and days-of-week configurable in JqueryUI datepicker

## Status
Beta, please test thoroughly before using in production sites

## Description
Adds config options for the JqueryUI datepicker to InputfieldDatetime:

![New config fields](https://github.com/BitPoet/bitpoet.github.io/blob/master/img/dpe_config.png)

### Excluded Days of Week
Lets you check which days of the week are generally disabled in the datetime picker.

### Hover Text for Excluded Days of Week
As the name says, this text is displayed if the user hovers over a day of week that was disabled.

![Example hover text for excluded day of week](https://github.com/BitPoet/bitpoet.github.io/blob/master/img/dpe_ex1.png)

### Dates to Exclude
You can also exclude specific dates. Just enter a list of dates in the format yyyymmdd in the
textarea.

Example: ```20231020,20231021```

You can also add an optional hover text to every date here by appending it with an "=".

Example: ```20231020=Away for the company summer party,20231021=Closed due to annual stocktaking```

![Example hover text for specific date](https://github.com/BitPoet/bitpoet.github.io/blob/master/img/dpe_ex2.png)

### First Day of Week
This isn't directly related to exclusions, but it lets you set which day is the first day of week.
Normally, JqueryUI datepicker should deduce this automatically from the browser's regional settings,
but you may want to override it.

## Todo

- Make exclusions also apply to the InputfieldDatetime.

## License

Licensed under Mozilla Public Lizense v2. See file LICENSE for details.
