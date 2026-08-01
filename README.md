# PAM Native Subscriptions

StoreKit 2 and Google Play Billing subscriptions with products/offers, purchases, pending states, restore, signed JWS or Play purchase tokens, and explicit Play acknowledgement after server verification.

Never grant durable entitlement from the device callback alone. Send `verification` to your backend, validate it with the App Store Server API or Google Play Developer API, persist the entitlement, then acknowledge Google Play purchases.

## Install

```bash
composer require pushinbr/pam-native-subscriptions
pam mobile prepare
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
