```php
public function onFragGrenadeExplode(FragGrenadeExplodeEvent $event) {
    $owner = $event->getOwner();
    $victim = $event->getVictim();
    $distance = $event->getDistance();
}

public function onFlameBottleExplode(FlameBottleExplodeEvent $event) {
    $owner = $event->getOwner();
    $victim = $event->getVictim();
}
```