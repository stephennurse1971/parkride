<?php

namespace Jsvrcek\ICS\Tests;

use Jsvrcek\ICS\Model\CalendarAlarm;
use Jsvrcek\ICS\Model\Recurrence\DataType\Weekday;

use Jsvrcek\ICS\Model\Recurrence\DataType\WeekdayNum;

use Jsvrcek\ICS\Model\Recurrence\DataType\Frequency;

use Jsvrcek\ICS\Model\Recurrence\RecurrenceRule;

use Jsvrcek\ICS\Model\Relationship\Organizer;

use Jsvrcek\ICS\Utility\Formatter;

use Jsvrcek\ICS\CalendarStream;

use Jsvrcek\ICS\Model\Relationship\Attendee;

use Jsvrcek\ICS\CalendarExport;
use Jsvrcek\ICS\Model\Calendar;
use Jsvrcek\ICS\Model\CalendarEvent;

class CalendarExportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Jsvrcek\ICS\CalendarExport::getStream
     */
    public function testGetStream()
    {
        $timezone = new \DateTimeZone('Antarctica/McMurdo');
        
        $organizer = new Organizer(new Formatter());
        $organizer->setValue('sue@example.com')
            ->setName('Sue Jones')
            ->setSentBy('mary@example.com')
            ->setLanguage('en');

        $attendee = new Attendee(new Formatter());
        $attendee->setName('Jane Smith')
            ->setCalendarUserType('INDIVIDUAL')
            ->setParticipationStatus('ACCEPTED')
            ->setRole('REQ-PARTICIPANT')
            ->setSentBy('joe@example')
            ->addCalendarMember('list@example.com')
            ->setValue('jane-smith@example.com');

        $event = new CalendarEvent();
        $event->setUid('lLKjd89283oja89282lkjd8@example.com')
            ->setStart(new \DateTime('1 October 2013', $timezone))
            ->setEnd(new \DateTime('31 October 2013', $timezone))
            ->setSummary('Oktoberfest at the South Pole')
            ->addAttendee($attendee)
            ->setOrganizer($organizer)
            ->setSequence(3)
            ->setTimestamp(new \DateTime('1 September 2013', $timezone));

        $rrule = new RecurrenceRule(new Formatter());
        $rrule->setFrequency(new Frequency(Frequency::MONTHLY))
            ->setInterval(2)
            ->setCount(6)
            ->addByDay(new WeekdayNum(Weekday::SATURDAY, 2));
        $event->setRecurrenceRule($rrule);

        //add an alarms to this event
        $alarmAudio = new CalendarAlarm();
        $alarmAudio->setAction("audio");
        $alarmAudio->setTrigger($event->getStart());
        $alarmAudio->addAttachment("FMTTYPE=audio/basic:ftp://example.com/pub/sounds/bell-01.aud");
        $event->addAlarm($alarmAudio);

        $alarmDisplay = new CalendarAlarm();
        $alarmDisplay->setAction("display");
        $alarmDisplay->setTrigger($event->getStart());
        $alarmDisplay->setRepeat(3);
        $alarmDisplay->setDuration(new \DateInterval('PT15M'));
        $alarmDisplay->setDescription("DESCRIPTION");
        $event->addAlarm($alarmDisplay);

        $alarmEmail = new CalendarAlarm();
        $alarmEmail->setAction('email');
        $alarmEmail->setTrigger($event->getStart());
        $alarmEmail->addAttendee($attendee);
        $alarmEmail->setSummary("EMAIL SUBJECT");
        $alarmEmail->setDescription("EMAIL BODY");
        $alarmEmail->addAttachment("FMTTYPE=application/msword:http://example.com/agenda.docx");
        $alarmEmail->addAttachment("FMTTYPE=application/pdf:http://example.com/agenda.pdf");
        $event->addAlarm($alarmEmail);

        $cal = new Calendar();
        $cal->setProdId('-//Jsvrcek//ICS//EN')
            ->setTimezone($timezone)
            ->addEvent($event);

        //create second calendar using batch event provider
        $timezone = new \DateTimeZone('Arctic/Longyearbyen');
        $calTwo = new Calendar();
        $calTwo->setProdId('-//Jsvrcek//ICS//EN2')
            ->setTimezone($timezone);

        $calTwo->setEventsProvider(function($start) use ($timezone){
            $eventOne = new CalendarEvent();
            $eventOne->setUid('asdfasdf@example.com')
                ->setStart(new \DateTime('2016-01-01 01:01:01', $timezone))
                ->setEnd(new \DateTime('2016-01-02 01:01:01', $timezone))
                ->setSummary('A long day')
                ->setTimestamp(new \DateTime('1 September 2013', $timezone));

            $eventTwo = new CalendarEvent();
            $eventTwo->setUid('asdfasdf@example.com')
                ->setStart(new \DateTime('2016-01-02 01:01:01', $timezone))
                ->setEnd(new \DateTime('2016-01-03 01:01:01', $timezone))
                ->setSummary('Another long day')
                ->setTimestamp(new \DateTime('1 September 2013', $timezone));

            return ($start > 0) ? array() : array($eventOne, $eventTwo);
        });

        $ce = new CalendarExport(new CalendarStream(), new Formatter());
        $ce->addCalendar($cal)
            ->addCalendar($calTwo);

        $stream = $ce->getStream();

        //file_put_contents(__DIR__.'/test.ics', $stream);

        $expected = file_get_contents(__DIR__.'/test.ics');

        $this->assertEquals($expected, $stream);
    }
}
