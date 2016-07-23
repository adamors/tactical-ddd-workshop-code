<?php
declare(strict_types = 1);

use Domain\Model\Meetup\Meetup;
use Domain\Model\Meetup\MeetupId;
use Domain\Model\Meetup\MeetupScheduled;
use Domain\Model\MeetupGroup\MeetupGroup;
use Domain\Model\Rsvp\Rsvp;
use Domain\Model\Rsvp\RsvpId;
use Domain\Model\User\User;
use Infrastructure\DomainEvents\DomainEventCliLogger;
use Infrastructure\DomainEvents\DomainEventDispatcher;
use Infrastructure\DomainEvents\Fixtures\DummyDomainEvent;
use Infrastructure\Persistence\InMemoryMeetupGroupRepository;
use Infrastructure\Persistence\InMemoryUserRepository;
use Ramsey\Uuid\Uuid;

require __DIR__ . '/vendor/autoload.php';

$userRepository = new InMemoryUserRepository();
$meetupGroupRepository = new InMemoryMeetupGroupRepository();

$eventDispatcher = new DomainEventDispatcher();
$eventDispatcher->subscribeToAllEvents(new DomainEventCliLogger());

$userId = $userRepository->nextIdentity();
$user = new User(
    $userId,
    'Matthias Noback',
    'matthiasnoback@gmail.com'
);
$userRepository->add($user);

$meetupGroupId = $meetupGroupRepository->nextIdentity();
$meetupGroup = new MeetupGroup(
    $meetupGroupId,
    'Ibuildings Events'
);
$meetupGroupRepository->add($meetupGroup);

$meetup = Meetup::schedule(
    MeetupId::fromString((string)Uuid::uuid4()),
    $userId,
    $meetupGroupId,
    'Laravel Barcelona Meetup',
    new \DateTimeImmutable()
);

$eventDispatcher->registerSubscriber(
    MeetupScheduled::class,
    function (MeetupScheduled $event) {
        $rsvp = Rsvp::rsvpYes(
            RsvpId::fromString((string)Uuid::uuid4()),
            $event->organiserId(),
            $event->meetupId()
        );
    }
);

foreach ($meetup->recordedEvents() as $event) {
    $eventDispatcher->dispatch(
        $event
    );
}
