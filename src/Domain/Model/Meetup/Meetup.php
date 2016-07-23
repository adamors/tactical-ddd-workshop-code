<?php

namespace Domain\Model\Meetup;

use Domain\Model\MeetupGroup\MeetupGroupId;
use Domain\Model\User\UserId;
use Infrastructure\DomainEvents\DomainEventRecordingCapabilities;
use Infrastructure\DomainEvents\RecordsDomainEvents;

final class Meetup implements RecordsDomainEvents
{
    use DomainEventRecordingCapabilities;

    /**
     * @var MeetupId
     */
    private $meetupId;
    /**
     * @var UserId
     */
    private $organiserId;
    /**
     * @var MeetupGroupId
     */
    private $meetupGroupId;
    /**
     * @var string
     */
    private $workingTitle;
    /**
     * @var \DateTimeImmutable
     */
    private $scheduledFor;

    private function __construct(
        MeetupId $meetupId,
        UserId $organiserId,
        MeetupGroupId $meetupGroupId,
        string $workingTitle,
        \DateTimeImmutable $scheduledFor
    ) {
        $this->meetupId = $meetupId;
        $this->organiserId = $organiserId;
        $this->meetupGroupId = $meetupGroupId;
        $this->workingTitle = $workingTitle;
        $this->scheduledFor = $scheduledFor;

        $this->recordThat(new MeetupScheduled(
            $meetupId,
            $organiserId,
            $meetupGroupId,
            $workingTitle,
            $scheduledFor
        ));
    }

    public static function schedule(
        MeetupId $meetupId,
        UserId $organiserId,
        MeetupGroupId $meetupGroupId,
        string $workingTitle,
        \DateTimeImmutable $scheduledFor
    ) : Meetup
    {
        return new self(
            $meetupId,
            $organiserId,
            $meetupGroupId,
            $workingTitle,
            $scheduledFor
        );
    }
}
