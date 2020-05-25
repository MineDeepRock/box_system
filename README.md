```php
public function onMedicineBoxEffectOn(MedicineBoxEffectOnEvent $event){
    $owner = $event->getOwner();
    $receiver = $event->getReceiver();
}
public function onAmmoBoxEffectOnEvent(AmmoBoxEffectOnEvent $event){
    $owner = $event->getOwner();
    $receiver = $event->getReceiver();
}
public function onFlareBoxEffectOnEvent(FlareBoxEffectOnEvent $event){
    $owner = $event->getOwner();
    $receiver = $event->getReceiver();
}
```