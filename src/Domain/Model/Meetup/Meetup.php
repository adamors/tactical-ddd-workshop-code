<?php

namespace Domain\Model\Meetup;

use Domain\Model\MeetupGroup\MeetupGroupId;
use Domain\Model\User\UserId;
use Infrastructure\DomainEvents\DomainEventRecordingCapabilities;
use Infrastructure\DomainEvents\RecordsDomainEvents;

final class Meetup implements RecordsDomainEvents
{
    use DomainEventRecordingCapabilities;

    private $meetupId;
    private $organizer;
    private $meetupGroupId;
    private $workingTitle;
    private $scheduledFor;

    private function __construct()
    {
    }

    public static function schedule(
        MeetupId $meetupId,
        UserId $organizer,
        MeetupGroupId $meetupGroupId,
        string $workingTitle,
        \DateTimeImmutable $scheduledFor
    ) : Meetup
    {
        $meetup = new Meetup();
        $meetup->recordThat(new MeetupScheduled(
            $meetupId,
            $organizer,
            $meetupGroupId,
            $workingTitle,
            $scheduledFor
        ));
        $meetup->meetupId = $meetupId;
        $meetup->organizer = $organizer;
        $meetup->meetupGroupId = $meetupGroupId;
        $meetup->workingTitle = $workingTitle;
        $meetup->scheduledFor = $scheduledFor;

        return $meetup;
    }
}
