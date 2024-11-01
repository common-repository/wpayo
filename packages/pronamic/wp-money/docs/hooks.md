# Hooks

- [Actions](#actions)
- [Filters](#filters)

## Actions

*This project does not contain any WordPress actions.*

## Filters

### `pronamic_money_default_format`

*Filters the default money format.*

Default format: `%%1$s%%2$s %%3$s`

- 1: Currency symbol
- 2: Amount value
- 3: Currency code

Note: use non-breaking space ` ` in money formatting.

**Arguments**

Argument | Type | Description
-------- | ---- | -----------
`$format` | `string` | Format.

Source: [src/Money.php](../src/Money.php), [line 59](../src/Money.php#L59-L72)

