<?php

namespace Domain\Model\Meetup;

use Domain\Model\MeetupGroup\MeetupGroupId;
use Domain\Model\User\UserId;

final class MeetupScheduled
{
    /**
     * @var MeetupId
     */
    private $meetupId;
    /**
     * @var UserId
     */
    private $organizer;
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

    public function __construct(
        MeetupId $meetupId,
        UserId $organizer,
        MeetupGroupId $meetupGroupId,
        string $workingTitle,
        \DateTimeImmutable $scheduledFor
    ) {
        $this->meetupId = $meetupId;
        $this->organizer = $organizer;
        $this->meetupGroupId = $meetupGroupId;
        $this->workingTitle = $workingTitle;
        $this->scheduledFor = $scheduledFor;
    }

    public function organizer()
    {
        return $this->organizer;
    }

    public function id()
    {
        return $this->meetupId;
    }
}
