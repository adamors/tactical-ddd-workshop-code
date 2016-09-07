<?php
declare(strict_types = 1);

use Domain\Model\Meetup\Meetup;
use Domain\Model\Meetup\MeetupRepository;
use Domain\Model\Meetup\MeetupScheduled;
use Domain\Model\MeetupGroup\MeetupGroup;
use Domain\Model\Rsvp\Rsvp;
use Domain\Model\Rsvp\RsvpRepository;
use Domain\Model\User\User;
use Infrastructure\DomainEvents\DomainEventCliLogger;
use Infrastructure\DomainEvents\DomainEventDispatcher;
use Infrastructure\DomainEvents\Fixtures\DummyDomainEvent;
use Infrastructure\Persistence\InMemoryMeetupGroupRepository;
use Infrastructure\Persistence\InMemoryUserRepository;

require __DIR__ . '/vendor/autoload.php';

$userRepository = new InMemoryUserRepository();
$meetupGroupRepository = new InMemoryMeetupGroupRepository();

$eventDispatcher = new DomainEventDispatcher();
$eventDispatcher->subscribeToAllEvents(new DomainEventCliLogger());

$user = new User(
    $userRepository->nextIdentity(),
    'Matthias Noback',
    'matthiasnoback@gmail.com'
);
$userRepository->add($user);

$meetupGroup = new MeetupGroup(
    $meetupGroupRepository->nextIdentity(),
    'Ibuildings Events'
);
$meetupGroupRepository->add($meetupGroup);

$eventDispatcher->dispatch(new DummyDomainEvent());


/** @var $meetupRepository MeetupRepository */
$meetup = Meetup::schedule(
    $meetupRepository->nextIdentity(),
    $user->userId(),
    $meetupGroup->meetupGroupId(),
    'Coding Dojo',
    new \DateTimeImmutable()
);

/** @var $rsvpRepository RsvpRepository */
$rsvpRepository = new InMemoryRsvpRepository();
$eventDispatcher->registerSubscriber(
    MeetupScheduled::class,
    function (MeetupScheduled $event) use ($rsvpRepository) {
        $rsvpRepository->add(
            Rsvp::yes(
                $rsvpRepository->nextIdentity(),
                $event->id(),
                $event->organizer()
            )
        );
    }
);

foreach ($meetup->recordedEvents() as $event) {
    $eventDispatcher->dispatch($event);
}
