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
     * @var MeetupId
     */
    private $meetupId;
    /**
     * @var UserId
     */
    private $participant;
    private $answer;

    private function __construct(
        RsvpId $rsvpId,
        MeetupId $meetupId,
        UserId $participant,
        $answer
    ) {
        $this->rsvpId = $rsvpId;
        $this->meetupId = $meetupId;
        $this->participant = $participant;
        $this->answer = $answer;
    }

    public static function yes(
        RsvpId $rsvpId,
        MeetupId $meetupId,
        UserId $participant
    ) {
        return new self($rsvpId, $meetupId, $participant, self::YES);
    }

    public static function no(
        RsvpId $rsvpId,
        MeetupId $meetupId,
        UserId $participant
    ) {
        return new self($rsvpId, $meetupId, $participant, self::NO);
    }
}
