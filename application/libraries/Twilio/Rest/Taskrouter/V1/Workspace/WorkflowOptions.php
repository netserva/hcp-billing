<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Options;
use Twilio\Values;

abstract class WorkflowOptions
{
    /**
     * @param string $friendlyName                  descriptive string that you create to describe
     *                                              the Workflow resource
     * @param string $assignmentCallbackUrl         The URL from your application that will
     *                                              process task assignment events
     * @param string $fallbackAssignmentCallbackUrl The URL that we should call
     *                                              when a call to the
     *                                              `assignment_callback_url` fails
     * @param string $configuration                 A JSON string that contains the rules to apply
     *                                              to the Workflow
     * @param int    $taskReservationTimeout        How long TaskRouter will wait for a
     *                                              confirmation response from your
     *                                              application after it assigns a Task to a
     *                                              Worker
     * @param string $reEvaluateTasks               Whether or not to re-evaluate Tasks
     *
     * @return UpdateWorkflowOptions Options builder
     */
    public static function update(string $friendlyName = Values::NONE, string $assignmentCallbackUrl = Values::NONE, string $fallbackAssignmentCallbackUrl = Values::NONE, string $configuration = Values::NONE, int $taskReservationTimeout = Values::NONE, string $reEvaluateTasks = Values::NONE): UpdateWorkflowOptions
    {
        return new UpdateWorkflowOptions($friendlyName, $assignmentCallbackUrl, $fallbackAssignmentCallbackUrl, $configuration, $taskReservationTimeout, $reEvaluateTasks);
    }

    /**
     * @param string $friendlyName The friendly_name of the Workflow resources to
     *                             read
     *
     * @return ReadWorkflowOptions Options builder
     */
    public static function read(string $friendlyName = Values::NONE): ReadWorkflowOptions
    {
        return new ReadWorkflowOptions($friendlyName);
    }

    /**
     * @param string $assignmentCallbackUrl         The URL from your application that will
     *                                              process task assignment events
     * @param string $fallbackAssignmentCallbackUrl The URL that we should call
     *                                              when a call to the
     *                                              `assignment_callback_url` fails
     * @param int    $taskReservationTimeout        How long TaskRouter will wait for a
     *                                              confirmation response from your
     *                                              application after it assigns a Task to a
     *                                              Worker
     *
     * @return CreateWorkflowOptions Options builder
     */
    public static function create(string $assignmentCallbackUrl = Values::NONE, string $fallbackAssignmentCallbackUrl = Values::NONE, int $taskReservationTimeout = Values::NONE): CreateWorkflowOptions
    {
        return new CreateWorkflowOptions($assignmentCallbackUrl, $fallbackAssignmentCallbackUrl, $taskReservationTimeout);
    }
}

class UpdateWorkflowOptions extends Options
{
    /**
     * @param string $friendlyName                  descriptive string that you create to describe
     *                                              the Workflow resource
     * @param string $assignmentCallbackUrl         The URL from your application that will
     *                                              process task assignment events
     * @param string $fallbackAssignmentCallbackUrl The URL that we should call
     *                                              when a call to the
     *                                              `assignment_callback_url` fails
     * @param string $configuration                 A JSON string that contains the rules to apply
     *                                              to the Workflow
     * @param int    $taskReservationTimeout        How long TaskRouter will wait for a
     *                                              confirmation response from your
     *                                              application after it assigns a Task to a
     *                                              Worker
     * @param string $reEvaluateTasks               Whether or not to re-evaluate Tasks
     */
    public function __construct(string $friendlyName = Values::NONE, string $assignmentCallbackUrl = Values::NONE, string $fallbackAssignmentCallbackUrl = Values::NONE, string $configuration = Values::NONE, int $taskReservationTimeout = Values::NONE, string $reEvaluateTasks = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['assignmentCallbackUrl'] = $assignmentCallbackUrl;
        $this->options['fallbackAssignmentCallbackUrl'] = $fallbackAssignmentCallbackUrl;
        $this->options['configuration'] = $configuration;
        $this->options['taskReservationTimeout'] = $taskReservationTimeout;
        $this->options['reEvaluateTasks'] = $reEvaluateTasks;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.Taskrouter.V1.UpdateWorkflowOptions '.$options.']';
    }

    /**
     * A descriptive string that you create to describe the Workflow resource. For example, `Inbound Call Workflow` or `2014 Outbound Campaign`.
     *
     * @param string $friendlyName descriptive string that you create to describe
     *                             the Workflow resource
     *
     * @return $this Fluent Builder
     */
    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;

        return $this;
    }

    /**
     * The URL from your application that will process task assignment events. See [Handling Task Assignment Callback](https://www.twilio.com/docs/taskrouter/handle-assignment-callbacks) for more details.
     *
     * @param string $assignmentCallbackUrl The URL from your application that will
     *                                      process task assignment events
     *
     * @return $this Fluent Builder
     */
    public function setAssignmentCallbackUrl(string $assignmentCallbackUrl): self
    {
        $this->options['assignmentCallbackUrl'] = $assignmentCallbackUrl;

        return $this;
    }

    /**
     * The URL that we should call when a call to the `assignment_callback_url` fails.
     *
     * @param string $fallbackAssignmentCallbackUrl The URL that we should call
     *                                              when a call to the
     *                                              `assignment_callback_url` fails
     *
     * @return $this Fluent Builder
     */
    public function setFallbackAssignmentCallbackUrl(string $fallbackAssignmentCallbackUrl): self
    {
        $this->options['fallbackAssignmentCallbackUrl'] = $fallbackAssignmentCallbackUrl;

        return $this;
    }

    /**
     * A JSON string that contains the rules to apply to the Workflow. See [Configuring Workflows](https://www.twilio.com/docs/taskrouter/workflow-configuration) for more information.
     *
     * @param string $configuration A JSON string that contains the rules to apply
     *                              to the Workflow
     *
     * @return $this Fluent Builder
     */
    public function setConfiguration(string $configuration): self
    {
        $this->options['configuration'] = $configuration;

        return $this;
    }

    /**
     * How long TaskRouter will wait for a confirmation response from your application after it assigns a Task to a Worker. Can be up to `86,400` (24 hours) and the default is `120`.
     *
     * @param int $taskReservationTimeout How long TaskRouter will wait for a
     *                                    confirmation response from your
     *                                    application after it assigns a Task to a
     *                                    Worker
     *
     * @return $this Fluent Builder
     */
    public function setTaskReservationTimeout(int $taskReservationTimeout): self
    {
        $this->options['taskReservationTimeout'] = $taskReservationTimeout;

        return $this;
    }

    /**
     * Whether or not to re-evaluate Tasks. The default is `false`, which means Tasks in the Workflow will not be processed through the assignment loop again.
     *
     * @param string $reEvaluateTasks Whether or not to re-evaluate Tasks
     *
     * @return $this Fluent Builder
     */
    public function setReEvaluateTasks(string $reEvaluateTasks): self
    {
        $this->options['reEvaluateTasks'] = $reEvaluateTasks;

        return $this;
    }
}

class ReadWorkflowOptions extends Options
{
    /**
     * @param string $friendlyName The friendly_name of the Workflow resources to
     *                             read
     */
    public function __construct(string $friendlyName = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.Taskrouter.V1.ReadWorkflowOptions '.$options.']';
    }

    /**
     * The `friendly_name` of the Workflow resources to read.
     *
     * @param string $friendlyName The friendly_name of the Workflow resources to
     *                             read
     *
     * @return $this Fluent Builder
     */
    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;

        return $this;
    }
}

class CreateWorkflowOptions extends Options
{
    /**
     * @param string $assignmentCallbackUrl         The URL from your application that will
     *                                              process task assignment events
     * @param string $fallbackAssignmentCallbackUrl The URL that we should call
     *                                              when a call to the
     *                                              `assignment_callback_url` fails
     * @param int    $taskReservationTimeout        How long TaskRouter will wait for a
     *                                              confirmation response from your
     *                                              application after it assigns a Task to a
     *                                              Worker
     */
    public function __construct(string $assignmentCallbackUrl = Values::NONE, string $fallbackAssignmentCallbackUrl = Values::NONE, int $taskReservationTimeout = Values::NONE)
    {
        $this->options['assignmentCallbackUrl'] = $assignmentCallbackUrl;
        $this->options['fallbackAssignmentCallbackUrl'] = $fallbackAssignmentCallbackUrl;
        $this->options['taskReservationTimeout'] = $taskReservationTimeout;
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), '', ' ');

        return '[Twilio.Taskrouter.V1.CreateWorkflowOptions '.$options.']';
    }

    /**
     * The URL from your application that will process task assignment events. See [Handling Task Assignment Callback](https://www.twilio.com/docs/taskrouter/handle-assignment-callbacks) for more details.
     *
     * @param string $assignmentCallbackUrl The URL from your application that will
     *                                      process task assignment events
     *
     * @return $this Fluent Builder
     */
    public function setAssignmentCallbackUrl(string $assignmentCallbackUrl): self
    {
        $this->options['assignmentCallbackUrl'] = $assignmentCallbackUrl;

        return $this;
    }

    /**
     * The URL that we should call when a call to the `assignment_callback_url` fails.
     *
     * @param string $fallbackAssignmentCallbackUrl The URL that we should call
     *                                              when a call to the
     *                                              `assignment_callback_url` fails
     *
     * @return $this Fluent Builder
     */
    public function setFallbackAssignmentCallbackUrl(string $fallbackAssignmentCallbackUrl): self
    {
        $this->options['fallbackAssignmentCallbackUrl'] = $fallbackAssignmentCallbackUrl;

        return $this;
    }

    /**
     * How long TaskRouter will wait for a confirmation response from your application after it assigns a Task to a Worker. Can be up to `86,400` (24 hours) and the default is `120`.
     *
     * @param int $taskReservationTimeout How long TaskRouter will wait for a
     *                                    confirmation response from your
     *                                    application after it assigns a Task to a
     *                                    Worker
     *
     * @return $this Fluent Builder
     */
    public function setTaskReservationTimeout(int $taskReservationTimeout): self
    {
        $this->options['taskReservationTimeout'] = $taskReservationTimeout;

        return $this;
    }
}
