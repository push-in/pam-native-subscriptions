# PAM Native Subscriptions

StoreKit 2 and Google Play Billing subscriptions with products/offers, purchases, pending states, restore, signed JWS or Play purchase tokens, and explicit Play acknowledgement after server verification.

Never grant durable entitlement from the device callback alone. Send `verification` to your backend, validate it with the App Store Server API or Google Play Developer API, persist the entitlement, then acknowledge Google Play purchases.
