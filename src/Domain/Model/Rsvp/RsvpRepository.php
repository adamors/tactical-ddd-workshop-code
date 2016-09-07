<?php
declare(strict_types=1);

namespace Domain\Model\Rsvp;

interface RsvpRepository
{
    public function add(Rsvp $rsvp);

    public function getById(RsvpId $rsvpId) : Rsvp;

    public function nextIdentity() : RsvpId;
}
