<?php

namespace Domain\Model\Meetup;

use Domain\Model\MeetupGroup\MeetupGroupId;
use Domain\Model\User\UserId;

final class MeetupScheduled
{
    public function __construct(
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
    }

    /**
     * @return MeetupId
     */
    public function meetupId()
    {
        return $this->meetupId;
    }

    /**
     * @return UserId
     */
    public function organiserId()
    {
        return $this->organiserId;
    }
}
