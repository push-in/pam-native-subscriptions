# PAM Native Subscriptions

StoreKit 2 and Google Play Billing subscriptions with products/offers, purchases, pending states, restore, signed JWS or Play purchase tokens, and explicit Play acknowledgement after server verification.

Never grant durable entitlement from the device callback alone. Send `verification` to your backend, validate it with the App Store Server API or Google Play Developer API, persist the entitlement, then acknowledge Google Play purchases.

## Install

```bash
pam add subscriptions
pam doctor
```

Configure matching product identifiers in App Store Connect and Google Play Console before querying the catalog.

## Load and purchase

```php
use Pam\Native\Subscriptions\Subscriptions;

$subscriptions = new Subscriptions();
$subscriptions->products(['pro.monthly'], function (array $products) use ($subscriptions): void {
    $product = $products[0] ?? null;
    if ($product === null) {
        return;
    }

    $subscriptions->purchase(
        $product->identifier,
        fn ($transaction) => sendToYourBackend($transaction->verification),
        $product->offerToken,
    );
});
```

The purchase result distinguishes completed, pending, cancelled, and failed states through `SubscriptionPurchaseState`. Use `restore()` during account recovery and after sign-in on a new device.


## What installation does

`pam add subscriptions` resolves the official compatible package, performs a non-mutating Composer preflight, updates the normal `composer.json` and `composer.lock`, refreshes generated native integration when required, and leaves the project ready for `pam doctor` validation.

Use `pam packages` to inspect availability and `pam remove subscriptions` to uninstall the capability safely. Direct Composer commands are an advanced interoperability path; PAM is the supported application workflow.

## API guide

| API | Responsibility |
| --- | --- |
| `Subscriptions` | Load products, purchase, restore, and acknowledge. |
| `SubscriptionProduct` | Read normalized product, price, and offer metadata. |
| `SubscriptionTransaction` | Receive store verification material. |
| `SubscriptionPurchaseState` | Handle completed, pending, cancelled, and failed states. |

All coded states, kinds, and variants are sequential integer-backed enums. Use enum cases in application code; do not depend on raw wire numbers.

## Production checklist

- Verify every transaction with Apple or Google on your server.
- Persist entitlement server-side and reconcile it at sign-in.
- Acknowledge Google Play only after successful server verification.
- Run `pam doctor`, `pam test`, and a signed release build on every supported platform.
- Exercise denial, cancellation, backgrounding, process restart, and offline behavior before release.

## Troubleshooting

- **Products are empty:** verify identifiers, store availability, agreements, and test account.
- **Purchase remains pending:** preserve state and wait for store resolution.
- **Restore finds nothing:** verify the signed-in store account and server entitlement mapping.
- **Native integration is stale:** run `pam doctor --fix`, rebuild the native host, and inspect the first reported diagnostic.

## Compatibility and support

This package targets PAM Native `0.6.x`, Android API 26+, and iOS 15+ unless a platform-specific section above states a stricter requirement. Platform SDKs, credentials, entitlements, physical hardware, and store configuration remain application responsibilities.

- [PAM documentation](https://push-in.github.io/pam-docs/introduction/)
- [PAM Native overview](https://push-in.github.io/pam-docs/native/overview/)
- [Plugin and native capability model](https://push-in.github.io/pam-docs/native/plugins/)
- [Report an issue](https://github.com/push-in/pam-native-subscriptions/issues)

Security vulnerabilities should be reported through the repository security policy or GitHub private vulnerability reporting, not a public issue.
