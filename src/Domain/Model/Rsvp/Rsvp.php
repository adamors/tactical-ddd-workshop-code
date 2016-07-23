<?php

namespace Domain\Model\Rsvp;

use Domain\Model\Meetup\MeetupId;
use Domain\Model\User\UserId;

final class Rsvp
{
    const YES = 'yes';
    const NO = 'no';
    /**
     * @var RsvpId
     */
    private $rsvpId;
    /**
     * @var UserId
     */
    private $userId;
    /**
     * @var MeetupId
     */
    private $meetupId;
    /**
     * @var string
     */
    private $answer;

    private function __construct(
        RsvpId $rsvpId,
        UserId $userId,
        MeetupId $meetupId,
        string $answer
    ) {
        $this->rsvpId = $rsvpId;
        $this->userId = $userId;
        $this->meetupId = $meetupId;
        $this->answer = $answer;
    }

    public static function rsvpYes(
        RsvpId $rsvpId,
        UserId $userId,
        MeetupId $meetupId
    ) : Rsvp {
        return new self(
            $rsvpId,
            $userId,
            $meetupId,
            self::YES
        );
    }

    public static function rsvpNo(
        RsvpId $rsvpId,
        UserId $userId,
        MeetupId $meetupId
    ) : Rsvp {
        return new self(
            $rsvpId,
            $userId,
            $meetupId,
            self::NO
        );
    }
}
