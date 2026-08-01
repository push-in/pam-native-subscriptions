<?php
declare(strict_types=1);namespace Pam\Native\Subscriptions;final readonly class SubscriptionTransaction{public function __construct(public string$productIdentifier,public string$transactionIdentifier,public string$verification,public SubscriptionPurchaseState$state,public ?string$message=null){}}
