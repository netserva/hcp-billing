<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Conference extends TwiML
{
    /**
     * Conference constructor.
     *
     * @param string $name       Conference name
     * @param array  $attributes Optional attributes
     */
    public function __construct($name, $attributes = [])
    {
        parent::__construct('Conference', $name, $attributes);
    }

    /**
     * Add Muted attribute.
     *
     * @param bool $muted Join the conference muted
     */
    public function setMuted($muted): self
    {
        return $this->setAttribute('muted', $muted);
    }

    /**
     * Add Beep attribute.
     *
     * @param string $beep Play beep when joining
     */
    public function setBeep($beep): self
    {
        return $this->setAttribute('beep', $beep);
    }

    /**
     * Add StartConferenceOnEnter attribute.
     *
     * @param bool $startConferenceOnEnter Start the conference on enter
     */
    public function setStartConferenceOnEnter($startConferenceOnEnter): self
    {
        return $this->setAttribute('startConferenceOnEnter', $startConferenceOnEnter);
    }

    /**
     * Add EndConferenceOnExit attribute.
     *
     * @param bool $endConferenceOnExit End the conferenceon exit
     */
    public function setEndConferenceOnExit($endConferenceOnExit): self
    {
        return $this->setAttribute('endConferenceOnExit', $endConferenceOnExit);
    }

    /**
     * Add WaitUrl attribute.
     *
     * @param string $waitUrl Wait URL
     */
    public function setWaitUrl($waitUrl): self
    {
        return $this->setAttribute('waitUrl', $waitUrl);
    }

    /**
     * Add WaitMethod attribute.
     *
     * @param string $waitMethod Wait URL method
     */
    public function setWaitMethod($waitMethod): self
    {
        return $this->setAttribute('waitMethod', $waitMethod);
    }

    /**
     * Add MaxParticipants attribute.
     *
     * @param int $maxParticipants Maximum number of participants
     */
    public function setMaxParticipants($maxParticipants): self
    {
        return $this->setAttribute('maxParticipants', $maxParticipants);
    }

    /**
     * Add Record attribute.
     *
     * @param string $record Record the conference
     */
    public function setRecord($record): self
    {
        return $this->setAttribute('record', $record);
    }

    /**
     * Add Region attribute.
     *
     * @param string $region Conference region
     */
    public function setRegion($region): self
    {
        return $this->setAttribute('region', $region);
    }

    /**
     * Add Coach attribute.
     *
     * @param string $coach Call coach
     */
    public function setCoach($coach): self
    {
        return $this->setAttribute('coach', $coach);
    }

    /**
     * Add Trim attribute.
     *
     * @param string $trim Trim the conference recording
     */
    public function setTrim($trim): self
    {
        return $this->setAttribute('trim', $trim);
    }

    /**
     * Add StatusCallbackEvent attribute.
     *
     * @param string[] $statusCallbackEvent Events to call status callback URL
     */
    public function setStatusCallbackEvent($statusCallbackEvent): self
    {
        return $this->setAttribute('statusCallbackEvent', $statusCallbackEvent);
    }

    /**
     * Add StatusCallback attribute.
     *
     * @param string $statusCallback Status callback URL
     */
    public function setStatusCallback($statusCallback): self
    {
        return $this->setAttribute('statusCallback', $statusCallback);
    }

    /**
     * Add StatusCallbackMethod attribute.
     *
     * @param string $statusCallbackMethod Status callback URL method
     */
    public function setStatusCallbackMethod($statusCallbackMethod): self
    {
        return $this->setAttribute('statusCallbackMethod', $statusCallbackMethod);
    }

    /**
     * Add RecordingStatusCallback attribute.
     *
     * @param string $recordingStatusCallback Recording status callback URL
     */
    public function setRecordingStatusCallback($recordingStatusCallback): self
    {
        return $this->setAttribute('recordingStatusCallback', $recordingStatusCallback);
    }

    /**
     * Add RecordingStatusCallbackMethod attribute.
     *
     * @param string $recordingStatusCallbackMethod Recording status callback URL
     *                                              method
     */
    public function setRecordingStatusCallbackMethod($recordingStatusCallbackMethod): self
    {
        return $this->setAttribute('recordingStatusCallbackMethod', $recordingStatusCallbackMethod);
    }

    /**
     * Add RecordingStatusCallbackEvent attribute.
     *
     * @param string[] $recordingStatusCallbackEvent Recording status callback
     *                                               events
     */
    public function setRecordingStatusCallbackEvent($recordingStatusCallbackEvent): self
    {
        return $this->setAttribute('recordingStatusCallbackEvent', $recordingStatusCallbackEvent);
    }

    /**
     * Add EventCallbackUrl attribute.
     *
     * @param string $eventCallbackUrl Event callback URL
     */
    public function setEventCallbackUrl($eventCallbackUrl): self
    {
        return $this->setAttribute('eventCallbackUrl', $eventCallbackUrl);
    }

    /**
     * Add JitterBufferSize attribute.
     *
     * @param string $jitterBufferSize Size of jitter buffer for participant
     */
    public function setJitterBufferSize($jitterBufferSize): self
    {
        return $this->setAttribute('jitterBufferSize', $jitterBufferSize);
    }

    /**
     * Add ParticipantLabel attribute.
     *
     * @param string $participantLabel A label for participant
     */
    public function setParticipantLabel($participantLabel): self
    {
        return $this->setAttribute('participantLabel', $participantLabel);
    }
}
