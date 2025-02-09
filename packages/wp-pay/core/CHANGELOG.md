# Change Log

All notable changes to this project will be documented in this file.

This projects adheres to [Semantic Versioning](http://semver.org/) and [Keep a CHANGELOG](http://keepachangelog.com/).

## [Unreleased][unreleased]

## [4.9.2] - 2023-03-31

### Commits

- Added quotes around URLs in changed home URL notice. ([ea5f026](https://github.com/pronamic/wp-pay-core/commit/ea5f026d008ff2c4e5550a658695aff5b5e9eb56))

Full set of changes: [`4.9.1...4.9.2`][4.9.2]

[4.9.2]: https://github.com/pronamic/wp-pay-core/compare/v4.9.1...v4.9.2

## [4.9.1] - 2023-03-30

### Commits

- Fixed refunded amount check. ([073e1a7](https://github.com/pronamic/wp-pay-core/commit/073e1a7792f45f1961f83ff2e8ef7b4851d16b75))
- Fixed text domains. ([d2f591e](https://github.com/pronamic/wp-pay-core/commit/d2f591e9482272b62eda0dd1df9cfc669e7faec1), [af3a4ed](https://github.com/pronamic/wp-pay-core/commit/af3a4ed14be1c18d8126d72adf867e7f4d0eb294))
- Updated default payment status pages. ([f19598e](https://github.com/pronamic/wp-pay-core/commit/f19598e973ac82f289e37f2dfe8d6760a742dd13), [9e551f5](https://github.com/pronamic/wp-pay-core/commit/9e551f5650d196c5b4bdb9b3628d8b06301154aa))
- Updated tests. ([6f7a434](https://github.com/pronamic/wp-pay-core/commit/6f7a4342adfca277601b4153eb20c53b773cc456), [8029d8e](https://github.com/pronamic/wp-pay-core/commit/8029d8e33cc7cb6d74413a92192ba094587df964))

Full set of changes: [`4.9.0...4.9.1`][4.9.1]

[4.9.1]: https://github.com/pronamic/wp-pay-core/compare/v4.9.0...v4.9.1

## [4.9.0] - 2023-03-29
### Changed

- Extended support for refunds.

### Commits

- No longer create WordPress user for built-in form entries. ([10e04cf](https://github.com/pronamic/wp-pay-core/commit/10e04cf2597cc2c9ec322cf2c87d891e0fbce663))
- Fixed setting customer email address in subscription. ([5d853f1](https://github.com/pronamic/wp-pay-core/commit/5d853f18567355f78b74117ba05e1312a8d5dcdc))

### Composer

- Changed `pronamic/wp-money` from `^2.2` to `v2.4.0`.
	Release notes: https://github.com/pronamic/wp-money/releases/tag/v2.4.0
- Changed `pronamic/wp-number` from `^1.2` to `v1.3.0`.
	Release notes: https://github.com/pronamic/wp-number/releases/tag/v1.3.0
Full set of changes: [`4.8.0...4.9.0`][4.9.0]

[4.9.0]: https://github.com/pronamic/wp-pay-core/compare/v4.8.0...v4.9.0

## [4.8.0] - 2023-03-10
### Added

- Added a home URL change detector to warn users.

### Changed

- Simplified the payment status pages generator feature.

### Removed

- Removed webhook manager, instead there is now the home URL change detector feature.

Full set of changes: [`4.7.3...4.8.0`][4.8.0]

[4.8.0]: https://github.com/pronamic/wp-pay-core/compare/v4.7.3...v4.8.0

## [4.7.3] - 2023-02-23

### Commits

- Fixed duplicate execution of `$gateway->start( $payment )` in redirect routine of HTML form gateways. ([467aeb5](https://github.com/pronamic/wp-pay-core/commit/467aeb59e24846c0bbd01e88ff5e1191bcfde6b5))
- Lowered payment amount to `0.00` for credit card and PayPal authorizations when updating mandate. ([3132ff6](https://github.com/pronamic/wp-pay-core/commit/3132ff61a0a8f78f98c8f499e584364d7bfc869a))
- Use Mollie Checkout to choose payment method on manual subscription renewal. ([af9c0c9](https://github.com/pronamic/wp-pay-core/commit/af9c0c922b6abcbf5ff1c5bc9417a2ad9568db21))

Full set of changes: [`4.7.2...4.7.3`][4.7.3]

[4.7.3]: https://github.com/pronamic/wp-pay-core/compare/v4.7.2...v4.7.3

## [4.7.2] - 2023-02-07
### Changed

- Improved admin tour, only navigate to enabled modules.
- Improved admin dashboard, only show about page link when an about page is defined.
- Simplified database upgrades, all upgrades are now executed without user confirmation.

### Fixed

- Fixed "Fatal error: Uncaught Error: Undefined constant "PRONAMIC_PAY_DEBUG". ([10b7865](https://github.com/pronamic/wp-pay-core/commit/10b78655eea7c641ee33b0fb0cccc26037074067))

Full set of changes: [`4.7.1...4.7.2`][4.7.2]

[4.7.2]: https://github.com/pronamic/wp-pay-core/compare/v4.7.1...v4.7.2

## [4.7.1] - 2023-01-31
### Commits

- Updated minified forms style. ([8f8be83](https://github.com/pronamic/wp-pay-core/commit/8f8be830398a8488200dd0c1b74fd346a2cc6962))
- Select gateway if we already know which one to use, because there is only a single gateway registered. ([eea5b74](https://github.com/pronamic/wp-pay-core/commit/eea5b74230267f67b8c3db1f2ecc5415e29906cb))

### Composer

- Changed `php` from `>=8.0` to `>=7.4`.
Full set of changes: [`4.7.0...4.7.1`][4.7.1]

[4.7.1]: https://github.com/pronamic/wp-pay-core/compare/v4.7.0...v4.7.1

## [4.7.0] - 2023-01-18
### Fixed

- Show payment methods list in the built-in payment forms, solves problem with bank choice with iDEAL Advanced. ([#89](https://github.com/pronamic/wp-pay-core/issues/89))

### Commits

- Improve PHP 7.4 compat for now. ([b59cc53](https://github.com/pronamic/wp-pay-core/commit/b59cc53ae4974de599b4c635651f992173d87007))
- Use file hash as version for forms style. ([005a167](https://github.com/pronamic/wp-pay-core/commit/005a16743824a9e44bc5ff63b888d586bbaaf6d6))
- Fixed adding new payment method via subscription mandate page. ([0da98dd](https://github.com/pronamic/wp-pay-core/commit/0da98ddcf2baf8b063a94f629dfb25e348723c19))
- Set `checked` property instead of attribute in mandate selection. ([cad9298](https://github.com/pronamic/wp-pay-core/commit/cad929805172b5333ac8761c45569457478dd03c))
- Happy 2023. ([11bf73b](https://github.com/pronamic/wp-pay-core/commit/11bf73b3a4e7ab23f0a8fe904cbb7c9c2376805a))

Full set of changes: [`4.6.0...4.7.0`][4.7.0]

[4.7.0]: https://github.com/pronamic/wp-pay-core/compare/v4.6.0...v4.7.0

## [4.6.0] - 2022-12-20
### Updated

- Increased minimum PHP version to version `8` or higher.
- Improved support for PHP `8.1` and `8.2`.
- Removed usage of deprecated constant `FILTER_SANITIZE_STRING`.
- Updated `pronamic/wp-http` library to version `^1.2`.
- Updated logos library to version `1.13.0`. ([25ea2f9](https://github.com/pronamic/wp-pay-core/commit/25ea2f9661b1d9bd08bf6d55a13708f799c742f9))

### Fixed

- Fixed using Mollie client from `pronamic/wp-mollie`. ([dc21b2a](https://github.com/pronamic/wp-pay-core/commit/dc21b2a4f8a3a564bcc8936ae5c3c4560dc71682))
- The `display_post_states` hook is a filter, not an action. ([8b82c99](https://github.com/pronamic/wp-pay-core/commit/8b82c992957e5c2b083a9923b14690f88083d953))

### Changed

- Credit card properties are nullable. ([80a7db9](https://github.com/pronamic/wp-pay-core/commit/80a7db99cff86188477d3e93b1f02fb798986a3e))

### Removed

- Removed `Util::simplexml_load_string( $string )`, no longer used. ([ff878d7](https://github.com/pronamic/wp-pay-core/commit/ff878d7ba7f8934db0ce41696357933180ca00e2))
- Removed `Pronamic\WordPress\Pay\Core\Util::remote_get_body()` function, no longer used. ([e0faca4](https://github.com/pronamic/wp-pay-core/commit/e0faca4938c86f782baf9dd110830b9ee9859fde))
- Removed usage of deprecated `\FILTER_SANITIZE_STRING` in gateway settings fields. ([2a1e778](https://github.com/pronamic/wp-pay-core/commit/2a1e7780fce7b86f57b4bc1404c6d94cd71400bd))
- Removed unused `Util::input_has_vars()`. ([53fe34f](https://github.com/pronamic/wp-pay-core/commit/53fe34f47dc6bf9a14bef06b6b0a08c86f7ae157))
- Removed `Pronamic\WordPress\Pay\Core\XML\Security` class, no longer used. ([f7c9169](https://github.com/pronamic/wp-pay-core/commit/f7c91694a23fc84fb722c8277b31b1a5c59d633e))
- Removed unused method `Core\Util::input_fields_html()`. ([608597b](https://github.com/pronamic/wp-pay-core/commit/608597bee9c39e1dfd98b5dc7f31ff00a7ba334f))
- Removed `xmlseclibs.php`, library is no longer used. ([8c91fbb](https://github.com/pronamic/wp-pay-core/commit/8c91fbb439f387e497996bea50d5524149da93c3))

### Added

- Added Riverty payment method constant. ([95ba774](https://github.com/pronamic/wp-pay-core/commit/95ba774643c387653e5b6a5a181b6f5501079424))

Full set of changes: [`4.5.0...4.6.0`][4.6.0]

[4.6.0]: https://github.com/pronamic/wp-pay-core/compare/v4.5.0...v4.6.0

## [4.5.0] - 2022-11-03
- Catch exceptions while retrieving options from for example iDEAL issuer select fields. ([#78](https://github.com/pronamic/wp-pay-core/issues/78))
- Allow subscription payments at gateways that don't have support for recurring payments. ([pronamic/wp-pronamic-pay-woocommerce#15](https://github.com/pronamic/wp-pronamic-pay-woocommerce/issues/15))
- Added MobilePay payment method. ([pronamic/wp-pronamic-pay-adyen#16](https://github.com/pronamic/wp-pronamic-pay-adyen/issues/16))

## [4.4.1] - 2022-10-11
- Added support for multi-dimensional array in `Util::html_hidden_fields()` method (pronamic/wp-pay-core#73).
- Fixed setting empty consumer bank details object (pronamic/wp-pronamic-pay-mollie#11).
- Removed payment method specific support values `recurring_apple_pay`, `recurring_credit_card` and `recurring_direct_debit`.
- Removed `Gateway->update_subscription( Payment $payment )` method, no longer used. ([pronamic/wp-pay-core#41](https://github.com/pronamic/wp-pay-core/issues/41))
- Removed `Gateway->cancel_subscription( Subscription $subscription )` method, no longer used. ([pronamic/wp-pay-core#41](https://github.com/pronamic/wp-pay-core/issues/41)).

## [4.4.0] - 2022-09-26
- Fixed list table styling on mobile (pronamic/wp-pay-core#72).
- Refactored payments methods and fields support.
- Removed phone number field from test meta box.
- Removed Sisow reservation payments support.

## [4.3.1] - 2022-07-01
### Changed
- Updated logos library to version `1.8.3`.

## [4.3.0] - 2022-06-30
### Added
- Added billing and shipping address details to test payments.
- Added tax details to test payments.
- Added `Authorized` payment status. ([#pronamic/wp-pay-core#66](https://github.com/pronamic/wp-pay-core/issues/66))

### Fixed
- Fixed "PHP Deprecated: locale_accept_from_http(): Passing null to parameter #1 ($header) of type string is deprecated".

## [4.2.1] - 2022-06-03
### Fixed
- Improved Pronamic service call.

## [4.2.0] - 2022-05-30
### Added
- Added support for other currencies in WordPress admin test meta box.
- Added support for required field in payment gateway settings API.
- Added payment charged back amount support. ([pronamic/wp-pronamic-pay#165](https://github.com/pronamic/wp-pronamic-pay/issues/165), [pronamic/wp-pronamic-pay#170](https://github.com/pronamic/wp-pronamic-pay/issues/170))

### Changed
- Updated logos library to version `1.8.2`.
- Add payment note on invalid gateway configuration ID. ([#pronamic/wp-pronamic-pay#195](https://github.com/pronamic/wp-pronamic-pay/issues/195))
- Add gateway ID to payment gateway JSON for convenience.

### Fixed
- Continue processing other gateways on error when updating active payment methods.

## [4.1.3] - 2022-05-04
### Changed
- Solved some PHPStan and Psalm errors.
- Improved PHP 8.1 support.

### Removed
- Removed `plugins_api` filter, callback does not exist.
- Removed specific s2Member code, we no longer support s2Member.
- Removed specific WP e-Commerce code, we no longer support WP e-Commerce.

## [4.1.2] - 2022-04-19
### Fixed
- Fixed plugin updater.

## [4.1.1] - 2022-04-12
### Changed
- Changed WordPress requirement from `^5.9` to `^5.7`.

## [4.1.0] - 2022-04-11
### Added
- Added a user interface to change a subscription's next payment date.
- Added a count badge in the WordPress admin menu for the number of subscriptions on hold.

### Changed
- The next payment date is now stored in the subscription and no longer in the subscription phases.

### Removed
- The general / global gateway integration mode setting for test or live mode is removed.
- Sorting payments by customer or transaction number in the WordPress admin dashboard has been removed.

## [4.0.2] - 2022-02-16
- Changed minimum PHP version requirement to `7.4` ([pronamic/wp-pronamic-pay#274](https://github.com/pronamic/wp-pronamic-pay/issues/274)).
- Changed follow-up payments query to subscriptions which needed renewal in past 24 hours only.
- Added next payment date column in subscriptions admin ([pronamic/wp-pronamic-pay#288](https://github.com/pronamic/wp-pronamic-pay/issues/288)).
- Fixed empty payment description admin column.
- Fixed error on subscription mandate selection page with invalid Mollie customer.
- Fixed possible infinite loop on updating active payment methods ([#54](https://github.com/pronamic/wp-pay-core/issues/54)).
- Fixed setting Mollie sequence type when manually re-trying payment for a period.
- Updated scheduling follow-up payments pages.
- Updated site health tests and debug information.
- Updated [pronamic/wp-pay-logos](https://github.com/pronamic/wp-pay-logos) library to version `1.7.1`.
- Removed time from next payment dates in admin.

## [4.0.1] - 2022-01-10
### Changed
- Set https://actionscheduler.org/ version constraint to `^3.0`.

## [4.0.0] - 2022-01-10
### Added
- Added setting to disable subscriptions processing (requires debug mode to enable).
- Added https://actionscheduler.org/ library for subscription processes.
- Added BLIK and MB WAY payment methods.
- Added support for TWINT payment method.
- Added payment method icon to amount column and info meta boxes.

### Changed
- Refactored subscription follow-up payments processes.
- Increased WordPress requirement to version `5.2` or higher.
- Improved usage of https://github.com/pronamic/wp-money.
- Updated https://github.com/pronamic/wp-html library.
- Updated https://github.com/pronamic/wp-pay-logos to version `1.7.0`.
- Cleaned up legacy properties and functions.
- Store less data in post meta.
- Solved all PHPStan errors.
- Explain badge count in admin menu by adding `title` attribute.

### Removed
- Removed http://www.ideal-status.nl/ dashboard widget.
- Removed Moneyou brand.

## [3.2.0] - 2021-09-30
- Start using `<input type="number">` in payment forms en test meta box.
- Removed `Util::string_to_amount( $value )` function.
- Updated logo library to version `1.6.8` for new Bancontact logo.
- Improved security by using correct escaping functions.

## [3.1.1] - 2021-09-16
- Fixed possible fatal error in subscription payments meta box (fixes [pronamic/wp-pronamic-pay#206](https://github.com/pronamic/wp-pronamic-pay/issues/206)).

## [3.1.0] - 2021-09-03
- No longer create recurring payments for subscriptions with the status `Failed` (see https://github.com/pronamic/wp-pronamic-pay/issues/188#issuecomment-907155800).
- No longer set payments with an empty amount to success (gateways and extensions should handle this).
- Subscription renewal page uses last failed period for manual renewal, if failed period has not yet passed.
- Fixed block titles ([pronamic/wp-pronamic-pay#185](https://github.com/pronamic/wp-pronamic-pay/issues/185)).
- Fixed layout issue with input HTML on subscription renewal page.
- Fixed script error in payment form block.

## [3.0.1] - 2021-08-16
### Added
- Added debug page for subscriptions follow-up payments.
- Added support for 'American Express' payment method.
- Added support for 'Mastercard' payment method.
- Added support for 'Visa' payment method.
- Added support for 'V PAY' payment method.

## [3.0.0] - 2021-08-05
### Changed
- Updated to `pronamic/wp-money` version ` 2.0.0`.
- No longer require taxed money in payments and subscriptions.
- Gateway in WordPress admin dashboard is now clickable.
- Updated subscription action URLs to include trailing slash.
- Made transaction ID searchable by inclusion in payment JSON post content.
- Updated hooks documentation.

### Added
- Added support for SprayPay payment method.

### Fixed
- Fixed payment form amount input styling with WordPress default theme.
- Fixed deprecated `block_categories` filter warning with WordPress 5.8.

### Removed
- Removed [Shortcake (Shortcode UI)](https://wordpress.org/plugins/shortcode-ui/) support.

## [2.7.2] - 2021-06-18
- Added payment method to subscription details when cancelling/renewing a subscription.
- Added refunded amount in payments overview amount column.
- Fixed using user locale on payment redirect and subscription action pages [#136](https://github.com/pronamic/wp-pronamic-pay/issues/136).
- Improved changing subscription mandate.

## [2.7.1] - 2021-05-27
- Added transaction description setting to payment forms.
- Updated payment methods logos to version 1.6.6.
- Fixed missing `On Hold` status in payment status map.

## [2.7.0] - 2021-04-26
- Added initial support for refunds.
- Added support for creating mandate with free trial periods.
- Added support for Swish and Vipps payment methods.
- Fixed setting post author `0` as customer user ID.
- Fixed subscription memory inconsistencies.
- Fixed subscription status updated to previous status when using manual payment status check.
- Improved manually renewing canceled subscriptions.
- Updated active tab item highlight to use WordPress color scheme.
- Updated redirect and subscription cancel/renew pages.
- Removed parameter `$post_id` from `Subscription` constructor (use `get_pronamic_subscription()` instead).
- Started using `pronamic/wp-html` and `pronamic/wp-http`.

## [2.6.2] - 2021-01-21
- Happy 2021.
- Added debug mode setting.
- Improved setting `utm_nooverride` parameter in redirect URL.

## [2.6.1] - 2021-01-18
- Added support for recurring payments with Apple Pay.

## [2.6.0] - 2021-01-14
- Update wp-pay/logos to version 1.6.5.
- Removed payment data classes.
- Add check if gateway exists when getting config IDs for payment method.
- Only add user agent in payment info meta box if not empty.
- Make sure available payment method is also supported when adding gateway to active payment methods.
- Make sure available methods are also supported in payment method field options.
- Allow retrying payments for WooCommerce source.
- Prevent manually creating next period payment for WooCommerce subscriptions.
- Removed `$subscription_module->start_recurring( Subscription $subscription, $gateway = null, $recurring = true )`.
- Also set source for retry payment (fixes issue with RCP).
- Added helper `from_array` functions for more DRY programming.
- Set activated at for testing.
- Update export ignores in Git attributes.
- Update license activation notice text.
- Don't show license activated notice if option value and license status have not changed.
- Replace create next period payment button with row for next period in subscription payments meta box.
- Fix updating subscription dates on next period payment creation.
- Make subscription phases meta box responsive.
- New `human_readable_range()` method instead of range as `SubscriptionPeriod` string representation.
- Payment Gateway Referral Exclusions in Google Analytics.
- Added HTTP helper.
- Add Santander payment method.
- Update test payment for subscription phases (removes class `PaymentTestData` and fixes #37).
- Complement iDEAL issuer for `Direct Debit (mandate via iDEAL)` method.
- Update handling return key presses in gateway test meta box (resolves #31).
- Introduced new `wpayo_gateway_configuration_display_value` filter.
- Make sure to always set payment customer.
- Ask for confirmation before manually cancelling a subscription.
- Redirect to new 'Subscription Canceled' status page after cancelling subscriptions.
- Set currency in payment lines amount from lines.

## [2.5.1] - 2020-11-19
- Fixed always setting payment customer details.
- Fixed setting currency in payment lines amount.

## [2.5.0] - 2020-11-05
- Added support for subscription phases.
- Added support for Przelewy24 payment method.
- Improved data stores, reuse data from memory.
- Catch money parser exceptions in blocks.
- Introduced some traits for the DRY principle.
- Payments can be linked to multiple subscription periods.
- Improved support for subscription alignment and proration.
- Added REST API endpoint for subscription phases.
- Removed `$subscription->get_total_amount()` in favor of getting amount from phases.
- Removed ability to manually change subscription amount for now.
- No longer start recurring payments for expired subscriptions.

## [2.4.1] - 2020-07-22
- Display email address as customer in payments and subscriptions list and details for unknown customers.
- Fix using deprecated `email` and `customer_name` properties.

## [2.4.0] - 2020-07-08
- Added support for customer company name.
- Added support for updating subscription mandate.
- Added support for VAT number (validation via VIES).
- Added `get_pronamic_subscriptions_by_source()` function.
- Fixed possible duplicate payment on upgrade if pending recurring payment exists.
- Fixed updating subscription status to 'On Hold' only if subscription is not already active, when processing first payment.
- Improved subscription date calculations.
- Updated admin tour.

## [2.3.2] - 2020-06-02
- Add payment origin post ID.
- Add 'Pronamic Pay' block category.
- Fix subscriptions without next payment date.
- Fix incorrect formatted amount in payment form block.

## [2.3.1] - 2020-04-03
- Added optional `$args` parameter to `get_wpayo_payment_by_meta()` function.
- Added active plugin integrations to Site Health debug fields.
- Fixed unnecessarily showing upgrade button in new installations.

## [2.3.0] - 2020-03-18
- Added Google Pay support.
- Added Apple Pay payment method.
- Added support for payment failure reason.
- Added input fields for consumer bank details name and IBAN.
- Simplify recurrence details in subscription info meta box.
- Fixed setting initials if no first and last name are given.
- Abstracted plugin and gateway integration classes.

## [2.2.7] - 2020-02-03
- Added Google Analytics e-commerce `pronamic_pay_google_analytics_ecommerce_item_name` and `pronamic_pay_google_analytics_ecommerce_item_category` filters.
- Added support for dependencies in the abstract gateway integration class.
- Improved error handling for manual payment status check.
- Updated custom gender and date of birth input fields.
- Clean post cache to prevent duplicate status updates.
- Fixed duplicate payment for recurring payment.

## [2.2.6] - 2019-12-22
- Added filter `wpayo_payment_gateway_configuration_id` for payment gateway configuration ID.
- Added filter `pronamic_pay_return_should_redirect` to move return checks to gateway integrations.
- Added Polylang home URL support in payment return URL.
- Added user display name in payment info meta boxes.
- Added consumer and bank transfer bank details.
- Added support for payment expiry date.
- Added support for gateway manual URL.
- Added new dependencies system.
- Added new upgrades system.
- Fixed incorrect day of month for yearly recurring payments when using synchronized payment date.
- Fixed not starting recurring payments for gateways which don't support recurring payments.
- Fixed default payment method in form processor if required.
- Fixed empty dashboard widgets for untranslated languages.
- Fixed submit button for manual subscription renewal.
- Fixed duplicate currency symbol in payment forms.
- Fixed stylesheet on payment redirect.
- Improved payment methods tab in gateway settings.
- Improved updating active payment methods.
- Improved error handling with exceptions.
- Improved update routine.
- Set subscription status 'On hold' for cancelled and expired payments.
- Do not auto update subscription status when status is 'On hold'.
- Renamed 'Expiry Date' to 'Paid up to' in subscription info meta box.

## [2.2.5] - 2019-10-07
- Added `wpayo_payment_gateway_configuration_id` WordPress filter.
- Improved some translatable texts.

## [2.2.4] - 2019-10-04
- Updated `viison/address-splitter` library to version `0.3.3`.
- Move tools to site health debug information and status tests.
- Read plugin version from plugin file header.
- Catch money parser exception for test payments.
- Sepereated `Statuses` class in `PaymentStatus` and `SubscriptionStatus` class.
- Require `edit_payments` capability for payments related meta boxes on dashboard page.
- Set menu page capability to minimum required capability based on submenu pages.
- Only redirect to about page if not already viewed.
- Removed Google +1 button.
- Order payments by ascending date (fixes last payment as result in `Subscription::get_first_payment()`).
- Added new WordPress Pay icon.
- Added start, end, expiry, next payment (delivery) date to payment/subscription JSON.
- Introduced a custom REST API route for payments and subscriptions.
- Fixed handling settings field `filter` array.
- Catch and handle error when parsing input value to money object fails (i.e. empty string).
- Improved getting first subscription payment.

## [2.2.3] - 2019-08-30
- Fix gateways not loading (since version 2.2.2).

## [2.2.2] - 2019-08-30
- Handle gateway integration class name string for backwards compatibility.

## [2.2.1] - 2019-08-28
- Fixed column classes on tabs.

## [2.2.0] - 2019-08-26
- Added Gutenberg payment form block.
- Removed iDEAL simulator iDEAL Basic config, no longer available.
- Removed Postcode iDEAL, no longer available.
- Deleted AddOn class, no longer used.
- Introduced a 'pronamic_pay_update_payment' action.
- Added webhook manager to notice webhook URL changes.
- Added subscription 'Next Payment Delivery Date'.
- Changed name of direct debit mandate via payment methods.
- Added EPS payment method.
- Simplified integrations/gateways setup.
- Switched to WP_Query usage, no longer custom DB queries.
- Added subscription status 'On Hold'.
- Fixed responsive subscriptions table.
- Added dashboard widget 'Latest subscriptions'.
- Removed documentation tab.

## [2.1.6] - 2019-03-28
- Updated Tippy.js to version 3.4.1.
- Introduced a `$payment->get_edit_payment_url()` function to easy retrieve the edit payment URL.
- Introduced a `$payment->get_status_label()` function to retrieve easier a user friendly (translated) status label.
- Renamed status check event to `pronamic_pay_payment_status_check` without `seconds` argument and with different delays for recurring payments.
- Added space between HTML attributes when converting from array.
- Allow transaction ID to be null.
- Retrieving payments will now check on payment post type.
- Introduced Country, HouseNumber and Region classes.
- Simplify payment redirect (Ogone DirectLink answer moved to gateway).
- Added `key` query argument to pay redirect URL.
- Link recurring icon to subscription post edit.
- Add support for payment redirect with custom views.
- Register style `pronamic-pay-redirect` in plugin.
- Removed ABN AMRO iDEAL Easy, iDEAL Only Kassa and Internetkassa gateways.
- Keep main admin menu item active when editing payments/subscriptions/gateways/forms.
- Added `pronamic_pay_gateways` filter.
- Show Adyen and EMS gateway IDs in custom column.
- Fixed empty admin reports.

## [2.1.5] - 2019-02-04
- Fixed fatal error PaymentInfo expecting taxed money.
- Improved responsive admin tables for payments and subscriptions.

## [2.1.4] - 2019-01-24
- Improved locale to always includes a country.

## [2.1.3] - 2019-01-21
- Fixed empty payment and subscription customer names.
- Fixed missing user ID in payment customer.
- Updated storing payments and subscriptions.
- Allow manual subscription renewal also for gateways which support auto renewal.

## [2.1.2] - 2019-01-03
- Fixed empty payments and subscriptions list tables with 'All' filter since WordPress 5.0.2.

## [2.1.1] - 2018-12-19
- Fixed incomplete payment customer from legacy meta.

## [2.1.0] - 2018-12-10
- Added support for payment lines.
- Store payment data as JSON.
- Added support for customer data in payment.
- Added support for billing and shipping address in payment.
- Added support for AfterPay payment methods.
- Added Capayable.
- Updated Tippy.js to version 3.3.0.
- Removed unused payment processing status.
- Added new WordPress 5.0 post type labels.

## [2.0.8] - 2018-09-28
- Added `get_meta()` method to core gateway config factory.
- Updated Tippy.js from 2.6.0 to 3.0.2.

## [2.0.7] - 2018-09-14
- Fixed issue with Flot dependency.

## [2.0.6] - 2018-09-14
- Use non-locale aware float values in data stores and Items amount calculation.
- Updated Tippy.js from version 2.5.4 to 2.6.0.

## [2.0.5] - 2018-09-12
- Set default status of new payments to 'Open'.
- Added a personal name class.
- Use empty issuers array by default, instead of null.
- Introduced a private `complement_payment` function in preparation for removal of the payment data interface constructions.
- Deprecated unused `has_feedback` and `amount_minimum`.
- Moved `pronamic_pay_plugin()` to core functions.

## [2.0.4] - 2018-08-28
- New payments with amount equal to 0 (or empty) will now directly get the completed status.
- Use PHP BCMath library for money calculations when available.

## [2.0.3] - 2018-08-16
- Use pronamic/wp-money library to parse money strings.
- Added Maestro to list of payment methods.

## [2.0.2] - 2018-06-21
- Removed version and extensions from the plugin class, is now part of the arguments array.
- Added support for WordPress core privacy export and erasure feature.

## [2.0.1] - 2018-06-01
- Moved all Pronamic Pay plugin classes to this core library.

## [2.0.0] - 2018-05-09
- Switched to PHP namespaces.

## [1.3.14] - 2017-12-12
- Improved direct debit payment method support and add helper methods.

## [1.3.13] - 2017-09-14
- Added support for credit card issuers.
- Added bunq payment method constant.
- Added `Direct Debit mandate via Bancontact` payment method constant and name.
- Added Bunq payment method name and use permanent URL to news article.
- Changed HTML/CSS class of pay button.

## [1.3.12] - 2017-03-15
- Make sure payment methods are stored as array in transient.

## [1.3.11] - 2017-01-25
- Added new constant for the KBC/CBC Payment Button payment method.
- Added new constant for the Belfius Direct Net payment method.

## [1.3.10] - 2016-11-16
- Added new constant for the Maestro payment method.

## [1.3.9] - 2016-10-20
- Added some helper functions for mandates.

## [1.3.8] - 2016-07-06
- Changed order of payment methods (alphabetic).
- Added Bancontact payment constant to payments methods getter function.
- Added PayPal payment constant to payments methods getter function.
- Renamed 'Bancontact/Mister Cash' to 'Bancontact'.

## [1.3.7] - 2016-06-08
- Added PayPal payment method constant.
- Simplified the gateay payment start function.
- Added new constant for Bancontact payment method.
- Fixed text domain for translations.

## [1.3.6] - 2016-04-29
- Set payment method choice key for iDEAL only gateways.

## [1.3.5] - 2016-03-22
- Add Pronamic_WP_Pay_GatewaySettings::save_post() to modify data when a gateway is saved.

## [1.3.4] - 2016-03-02
- Use the new get_gateway_class() function which is new on the config objects.

## [1.3.3] - 2016-02-04
- Readded the MiniTix payment method constant for backwards compatibility.

## [1.3.2] - 2016-02-02
- Make sure to look to parent config class in the gateway factory.

## [1.3.1] - 2016-01-22
- Also try the parent class to fix issue with extended config.
- Improved the Pronamic_WP_Pay_Util::string_to_amount() function.
- Removed discontinued MiniTix gateway.

## [1.3.0] - 2016-01-07
- Added an gateway settings class.
- Added support for payment methods.
- Added utility to convert an amount from user input to float.

## [1.2.3] - 2015-10-19
- Added `get_payment_method()` and `set_payment_method()` function on gateway class.

## [1.2.2] - 2015-10-15
- Add payment method 'Bank transfer'.

## [1.2.1] - 2015-04-29
- Added XML utility class.

## [1.2.0] - 2015-03-26
- Added default filter to server variables get function.
- Allow gateways to return array with output fields in stead of HTML.

## [1.1.0] - 2015-02-27
- Added helper class for retrieving $_SERVER values.
- Added helper class to check of class method exists.

## [1.0.1] - 2015-02-16
- Added constant for the SOFORT Banking payment method.

## 1.0.0
- First release.

[unreleased]: https://github.com/pronamic/wp-pay-core/compare/4.5.0...HEAD
[4.5.0]: https://github.com/pronamic/wp-pay-core/compare/4.4.1...4.5.0
[4.4.1]: https://github.com/pronamic/wp-pay-core/compare/4.4.0...4.4.1
[4.4.0]: https://github.com/pronamic/wp-pay-core/compare/4.3.1...4.4.0
[4.3.1]: https://github.com/pronamic/wp-pay-core/compare/4.3.0...4.3.1
[4.3.0]: https://github.com/pronamic/wp-pay-core/compare/4.2.1...4.3.0
[4.2.1]: https://github.com/pronamic/wp-pay-core/compare/4.2.0...4.2.1
[4.2.0]: https://github.com/pronamic/wp-pay-core/compare/4.1.3...4.2.0
[4.1.3]: https://github.com/pronamic/wp-pay-core/compare/4.1.2...4.1.3
[4.1.2]: https://github.com/pronamic/wp-pay-core/compare/4.1.1...4.1.2
[4.1.1]: https://github.com/pronamic/wp-pay-core/compare/4.1.0...4.1.1
[4.1.0]: https://github.com/pronamic/wp-pay-core/compare/4.0.2...4.1.0
[4.0.2]: https://github.com/pronamic/wp-pay-core/compare/4.0.1...4.0.2
[4.0.1]: https://github.com/pronamic/wp-pay-core/compare/4.0.0...4.0.1
[4.0.0]: https://github.com/pronamic/wp-pay-core/compare/3.2.0...4.0.0
[3.2.0]: https://github.com/pronamic/wp-pay-core/compare/3.1.1...3.2.0
[3.1.1]: https://github.com/pronamic/wp-pay-core/compare/3.1.0...3.1.1
[3.1.0]: https://github.com/pronamic/wp-pay-core/compare/3.0.1...3.1.0
[3.0.1]: https://github.com/pronamic/wp-pay-core/compare/3.0.0...3.0.1
[3.0.0]: https://github.com/pronamic/wp-pay-core/compare/2.7.2...3.0.0
[2.7.2]: https://github.com/pronamic/wp-pay-core/compare/2.7.1...2.7.2
[2.7.1]: https://github.com/pronamic/wp-pay-core/compare/2.7.0...2.7.1
[2.7.0]: https://github.com/pronamic/wp-pay-core/compare/2.6.2...2.7.0
[2.6.2]: https://github.com/pronamic/wp-pay-core/compare/2.6.1...2.6.2
[2.6.1]: https://github.com/pronamic/wp-pay-core/compare/2.6.0...2.6.1
[2.6.0]: https://github.com/pronamic/wp-pay-core/compare/2.5.1...2.6.0
[2.5.1]: https://github.com/pronamic/wp-pay-core/compare/2.5.0...2.5.1
[2.5.0]: https://github.com/pronamic/wp-pay-core/compare/2.4.1...2.5.0
[2.4.1]: https://github.com/pronamic/wp-pay-core/compare/2.4.0...2.4.1
[2.4.0]: https://github.com/pronamic/wp-pay-core/compare/2.3.2...2.4.0
[2.3.2]: https://github.com/pronamic/wp-pay-core/compare/2.3.1...2.3.2
[2.3.1]: https://github.com/pronamic/wp-pay-core/compare/2.3.0...2.3.1
[2.3.0]: https://github.com/pronamic/wp-pay-core/compare/2.2.8...2.3.0
[2.2.8]: https://github.com/pronamic/wp-pay-core/compare/2.2.7...2.2.8
[2.2.7]: https://github.com/pronamic/wp-pay-core/compare/2.2.6...2.2.7
[2.2.6]: https://github.com/pronamic/wp-pay-core/compare/2.2.5...2.2.6
[2.2.5]: https://github.com/pronamic/wp-pay-core/compare/2.2.4...2.2.5
[2.2.4]: https://github.com/pronamic/wp-pay-core/compare/2.2.3...2.2.4
[2.2.3]: https://github.com/pronamic/wp-pay-core/compare/2.2.2...2.2.3
[2.2.2]: https://github.com/pronamic/wp-pay-core/compare/2.2.1...2.2.2
[2.2.1]: https://github.com/pronamic/wp-pay-core/compare/2.2.0...2.2.1
[2.2.0]: https://github.com/pronamic/wp-pay-core/compare/2.1.6...2.2.0
[2.1.6]: https://github.com/pronamic/wp-pay-core/compare/2.1.5...2.1.6
[2.1.5]: https://github.com/pronamic/wp-pay-core/compare/2.1.4...2.1.5
[2.1.4]: https://github.com/pronamic/wp-pay-core/compare/2.1.3...2.1.4
[2.1.3]: https://github.com/pronamic/wp-pay-core/compare/2.1.2...2.1.3
[2.1.2]: https://github.com/pronamic/wp-pay-core/compare/2.1.1...2.1.2
[2.1.1]: https://github.com/pronamic/wp-pay-core/compare/2.1.0...2.1.1
[2.1.0]: https://github.com/pronamic/wp-pay-core/compare/2.0.8...2.1.0
[2.0.8]: https://github.com/pronamic/wp-pay-core/compare/2.0.7...2.0.8
[2.0.7]: https://github.com/pronamic/wp-pay-core/compare/2.0.6...2.0.7
[2.0.6]: https://github.com/pronamic/wp-pay-core/compare/2.0.5...2.0.6
[2.0.5]: https://github.com/pronamic/wp-pay-core/compare/2.0.4...2.0.5
[2.0.4]: https://github.com/pronamic/wp-pay-core/compare/2.0.3...2.0.4
[2.0.3]: https://github.com/pronamic/wp-pay-core/compare/2.0.2...2.0.3
[2.0.2]: https://github.com/pronamic/wp-pay-core/compare/2.0.1...2.0.2
[2.0.1]: https://github.com/pronamic/wp-pay-core/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/pronamic/wp-pay-core/compare/1.3.14...2.0.0
[1.3.14]: https://github.com/pronamic/wp-pay-core/compare/1.3.13...1.3.14
[1.3.13]: https://github.com/pronamic/wp-pay-core/compare/1.3.12...1.3.13
[1.3.12]: https://github.com/pronamic/wp-pay-core/compare/1.3.11...1.3.12
[1.3.11]: https://github.com/pronamic/wp-pay-core/compare/1.3.10...1.3.11
[1.3.10]: https://github.com/pronamic/wp-pay-core/compare/1.3.9...1.3.10
[1.3.9]: https://github.com/pronamic/wp-pay-core/compare/1.3.8...1.3.9
[1.3.8]: https://github.com/pronamic/wp-pay-core/compare/1.3.7...1.3.8
[1.3.7]: https://github.com/pronamic/wp-pay-core/compare/1.3.6...1.3.7
[1.3.6]: https://github.com/pronamic/wp-pay-core/compare/1.3.5...1.3.6
[1.3.5]: https://github.com/pronamic/wp-pay-core/compare/1.3.4...1.3.5
[1.3.4]: https://github.com/pronamic/wp-pay-core/compare/1.3.3...1.3.4
[1.3.3]: https://github.com/pronamic/wp-pay-core/compare/1.3.2...1.3.3
[1.3.2]: https://github.com/pronamic/wp-pay-core/compare/1.3.1...1.3.2
[1.3.1]: https://github.com/pronamic/wp-pay-core/compare/1.3.0...1.3.1
[1.3.0]: https://github.com/pronamic/wp-pay-core/compare/1.2.3...1.3.0
[1.2.3]: https://github.com/pronamic/wp-pay-core/compare/1.2.2...1.2.3
[1.2.2]: https://github.com/pronamic/wp-pay-core/compare/1.2.1...1.2.2
[1.2.1]: https://github.com/pronamic/wp-pay-core/compare/1.2.0...1.2.1
[1.2.0]: https://github.com/pronamic/wp-pay-core/compare/1.1.0...1.2.0
[1.1.0]: https://github.com/pronamic/wp-pay-core/compare/1.0.1...1.1.0
[1.0.1]: https://github.com/pronamic/wp-pay-core/compare/1.0.0...1.0.1
