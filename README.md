# DatePickerExclusions
ProcessWire module that makes excluded days and days-of-week configurable in JqueryUI datepicker

## Status
Proof-of-concept. Only use in production if you really know what you are doing!

## Description
Adds config options for the JqueryUI datepicker to InputfieldDatetime:

![New config fields](https://github.com/BitPoet/bitpoet.github.io/blob/master/img/dpe_config.png)

### Excluded Days of Week
Lets you check which days of the week are generally disabled in the datetime picker.

### Hover Text for Excluded Days of Week
As the name says, this text is displayed if the user hovers over a day of week that was disabled.

![Example hover text for excluded day of week](https://github.com/BitPoet/bitpoet.github.io/blob/master/img/dpe_ex1.png)

### Dates to Exclude
You can also exclude specific dates. Just enter a list of dates in the format yyyy-mm-dd in the
textarea.

Example: ```2023-10-20,2023-10-21```

You can also add an optional hover text to every date here by appending it with an "=".

Example: ```2023-10-20=Away for the company party,2023-10-21=Closed due to annual stocktaking```

![Example hover text for specific date](https://github.com/BitPoet/bitpoet.github.io/blob/master/img/dpe_ex2.png)

### First Day of Week
This isn't directly related to exclusions, but it lets you set which day is the first day of week.
Normally, JqueryUI datepicker should deduce this automatically from the browser's regional settings,
but you may want to override it.

## Caveats

Doesn't work with inline datepickers (yet) as it relies on the focus event on the input.

## Todo

- Make exclusions also apply to the InputfieldDatetime.

## License

Licensed under Mozilla Public Lizense v2. See file LICENSE for details.
