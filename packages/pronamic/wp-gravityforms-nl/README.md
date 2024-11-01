# WordPress Gravity Forms (NL)

This WordPress plugin extends Gravity Forms with Dutch address notation and places the Euro sign to the left of input fields.

## WordPress Filters

### pronamic_gravityforms_nl_address_label

```php
function prefix_pronamic_gravityforms_nl_address_label( $label ) {
	return _x( 'Dutch', 'Dutch address type', 'wpayo' );
}

add_filter( 'pronamic_gravityforms_nl_address_label', 'prefix_pronamic_gravityforms_nl_address_label' );
```

### pronamic_gravityforms_nl_address_country

```php
function prefix_pronamic_gravityforms_nl_address_country( $country ) {
	return _x( 'Netherlands', 'Dutch address type', 'wpayo' );
}

add_filter( 'pronamic_gravityforms_nl_address_country', 'prefix_pronamic_gravityforms_nl_address_country' );
```

### pronamic_gravityforms_nl_address_zip_label

```php
function prefix_pronamic_gravityforms_nl_address_zip_label( $zip_label ) {
	return _x( 'Postal Code', 'Dutch address type', 'wpayo' );
}

add_filter( 'pronamic_gravityforms_nl_address_zip_label', 'prefix_pronamic_gravityforms_nl_address_zip_label' );
```

### pronamic_gravityforms_nl_address_state_label

```php
function prefix_pronamic_gravityforms_nl_address_state_label( $state_label ) {
	return _x( 'Province', 'Dutch address type', 'wpayo' );
}

add_filter( 'pronamic_gravityforms_nl_address_state_label', 'prefix_pronamic_gravityforms_nl_address_state_label' );
```

### pronamic_gravityforms_nl_address_states

```php
function prefix_pronamic_gravityforms_nl_address_states( $states ) {
	return array(
		__( 'Drenthe', 'wpayo' ),
		__( 'Flevoland', 'wpayo' ),
		__( 'Friesland', 'wpayo' ),
		__( 'Gelderland', 'wpayo' ),
		__( 'Groningen', 'wpayo' ),
		__( 'Limburg', 'wpayo' ),
		__( 'Noord-Brabant', 'wpayo' ),
		__( 'Noord-Holland', 'wpayo' ),
		__( 'Overijssel', 'wpayo' ),
		__( 'Utrecht', 'wpayo' ),
		__( 'Zeeland', 'wpayo' ),
		__( 'Zuid-Holland', 'wpayo' ),
	);
}

add_filter( 'pronamic_gravityforms_nl_address_states', 'prefix_pronamic_gravityforms_nl_address_states' );
```
