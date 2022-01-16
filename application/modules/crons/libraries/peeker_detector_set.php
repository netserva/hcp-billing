<?php

declare(strict_types=1);

/**
 * Manage set of detector-callback circuits.
 */
class peeker_detector_set
{
    // keep track of what happens
    public $log_array = [];

    // we can prepend this string
    // to any function that returns
    // boolean and it will invert result
    public $invert_detector_method_string = 'not__';
    public $invert_detector_method_string_length;

    // "inside the detector loop" switch for controlling detectors
    // default to FALSE, abort_detectors() turns on
    public $detectors_abort = false;
    // holds the detector objects
    public $detector_array = [];
    // holds the booleans that map to detectors
    public $detector_trigger_array = [];

    /**
     * Constructor
     * wrapper to add everything at once.
     */
    public function __construct()
    {
        // strlen the inverter string once
        $this->invert_detector_method_string_length = strlen($this->invert_detector_method_string);

        $this->log_array[] = 'LOADING detector-set class';
    }

    /**
     * run the check() method for detectors
     * in parallel with the trigger() method
     * for methods that returned TRUE on check()
     * Receive $em_message_object by reference.
     *
     * @param mixed $em_message_obj
     */
    public function run(&$em_message_obj): void
    {
        // reset the abort state for detectors
        // so that if we are in a multi-message
        // iteration each message can have its
        // own abort determination procedure.
        // abort is used inside the detector loop
        // on a per-message basis so that one
        // detector can bail and tell the rest
        // not to execute
        $this->detectors_abort(false);
        // NOTE: this design keeps detector checks
        // and callbacks together running in parallel.
        // check the registered detectors to see if the
        // detector method returns TRUE

        // run the check() method and record
        // the result for every detector
        $this->detector_trigger_array = [];
        foreach ($this->detector_array as $detector) {
            if ($this->detectors_abort) {
                $this->log_array[] = 'detectors_abort is TRUE, aborting.';

                break;
            }
            //p($detector);
            // $em_message_obj is received by reference
            // record the result in detector_trigger_array
            $trigger_it = $this->detector_trigger_array[] = $detector->check($em_message_obj);

            $this->log_array[] = (($detector->invert_detector) ? $this->invert_detector_method_string : '').$detector->detector_method.' Trigger? '.var_export($trigger_it, true).' args: '.var_export($detector->detector_method_arguments, true);
            // run the corresponding callback
            // for every check() that returned TRUE
            if ($trigger_it) {
                $detector->trigger($em_message_obj);
                $this->log_array[] = 'triggered callback: '.$detector->callback_method.' with: '.var_export($detector->callback_method_arguments, true);
            }
        }
    }

    /**
     * just run the triggers
     * testing just triggers.
     *
     * @param mixed $em_message_obj
     */
    public function run_triggers(&$em_message_obj): void
    {
        $this->detector_trigger_array = [];
        foreach ($this->detector_array as $detector) {
            if ($this->detectors_abort) {
                break;
            }
            //p($detector);
            // $em_message_obj is received by reference
            $this->detector_trigger_array[] = $detector->check($em_message_obj);
        }
    }

    /**
     * just run the callbacks
     * with optional culling
     * send TRUE to run all callbacks
     * for testing or reporting.
     *
     * @param mixed $em_message_obj
     * @param mixed $all
     */
    public function run_callbacks(&$em_message_obj, $all = false): void
    {
        if (false === $all) {
            // optimize, remove the FALSE detectors
            $this->detector_trigger_array = array_filter($this->detector_trigger_array);
        }
        // if there is a match or matches, trigger the
        // registered callback(s) to make something happen
        // generally, this would be to delete the message
        // at the mail server before downloading
        // or it could trigger db insertion, string
        // cleanup or routing routines per message
        foreach ($this->detector_trigger_array as $key => $trigger) {
            // $em_message_obj is received as reference so
            // the functions can operate on the data
            // if detectors aborted in detect phase, don't run callbacks
            if ($this->detectors_abort) {
                break;
            }
            $this->detector_array[$key]->trigger($em_message_obj);
        }
    }

    //------DETECTOR-CALLBACK methods------//

    /**
     * add a detector to be checked on every
     * message in message().
     *
     * @param mixed $detector_obj
     */
    public function _add_detector($detector_obj): void
    {
        $this->detector_array[] = $detector_obj;
        //p($this->detector_array);
        $this->log_array[] = 'Added detector: '.$detector_obj->get_detector();
        $this->log_array[] = 'Detector args: '.var_export($detector_obj->get_detector_arguments(), true);
        $this->log_array[] = 'Added callback: '.$detector_obj->get_callback();
        $this->log_array[] = 'Callback args: '.var_export($detector_obj->get_callback_arguments(), true);
    }

    /**
     * wrapper to add a detector
     * also, turns on detector checking.
     *
     * @param mixed $dm
     * @param mixed $dma
     * @param mixed $cm
     * @param mixed $cma
     */
    public function detector($dm, $dma, $cm, $cma)
    {
        include_once 'peeker_detector.php';
        $detector = new peeker_detector($dm, $dma, $cm, $cma, $this);
        $this->_add_detector($detector);
        $this->set_detectors_state(true);

        return $detector;
    }

    /**
     * wrapper to set up detector phase
     * method that will be called on every
     * message iteration - at detect stage
     * must send method/function name or array
     * just like for detector() method
     * should fix this so that it doesn't use
     * ttrue() method.
     *
     * @param mixed $dm
     * @param mixed $dma
     */
    public function detect_phase($dm, $dma = '')
    {
        return $this->detector($dm, $dma, 'ttrue', '');
    }

    /**
     * wrapper to set up callback phase
     * method that will be called on every
     * message iteration - at callback stage
     * after detector has been checked
     * must send method/function name or array
     * just like for detector() method
     * should fix this so that it doesn't use
     * ttrue() method.
     *
     * @param mixed $cm
     * @param mixed $cma
     */
    public function callback_phase($cm, $cma = '')
    {
        return $this->detector('ttrue', '', $cm, $cma);
    }

    /**
     * turn on/off detectors "globally"
     * but keep them around.
     *
     * @param mixed $state
     */
    public function set_detectors_state($state): void
    {
        $this->detectors_on = $state;
    }

    /**
     * abort the detector loop (do not trigger or check)
     * in messages() method.
     *
     * @param mixed $state
     */
    public function detectors_abort($state): void
    {
        $this->log_array[] = 'Setting detectors abort state: '.var_export($state, true);
        $this->detectors_abort = $state;
    }

    /**
     * accessor method: get the state array.
     */
    public function get_log_array()
    {
        return $this->log_array;
    }

    /**
     * settor method: set the state array.
     *
     * @param mixed $in
     */
    public function set_log_array($in): void
    {
        $this->log_array = $in;
    }

    /**
     * get most recent detector firing state
     * allows detectors to query previous detector
     * used by detectors / message objects to
     * do something special (e.g., abort the
     * detector loop) if any arbitrary detector
     * returns true - check right after in detector stack.
     */
    public function _get_previous_detector_state()
    {
        return end($this->detector_trigger_array);
    }
}

//EOF
