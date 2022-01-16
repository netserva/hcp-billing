<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Preview\DeployedDevices\Fleet;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 */
class CertificateList extends ListResource
{
    /**
     * Construct the CertificateList.
     *
     * @param Version $version  Version that contains the resource
     * @param string  $fleetSid the unique identifier of the Fleet
     */
    public function __construct(Version $version, string $fleetSid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['fleetSid' => $fleetSid];

        $this->uri = '/Fleets/'.\rawurlencode($fleetSid).'/Certificates';
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return '[Twilio.Preview.DeployedDevices.CertificateList]';
    }

    /**
     * Create the CertificateInstance.
     *
     * @param string        $certificateData the public certificate data
     * @param array|Options $options         Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return CertificateInstance Created CertificateInstance
     */
    public function create(string $certificateData, array $options = []): CertificateInstance
    {
        $options = new Values($options);

        $data = Values::of([
            'CertificateData' => $certificateData,
            'FriendlyName' => $options['friendlyName'],
            'DeviceSid' => $options['deviceSid'],
        ]);

        $payload = $this->version->create('POST', $this->uri, [], $data);

        return new CertificateInstance($this->version, $payload, $this->solution['fleetSid']);
    }

    /**
     * Streams CertificateInstance records from the API as a generator stream.
     * This operation lazily loads records as efficiently as possible until the
     * limit
     * is reached.
     * The results are returned as a generator, so this operation is memory
     * efficient.
     *
     * @param array|Options $options  Optional Arguments
     * @param int           $limit    Upper limit for the number of records to return. stream()
     *                                guarantees to never return more than limit.  Default is no
     *                                limit
     * @param mixed         $pageSize Number of records to fetch per request, when not set
     *                                will use the default value of 50 records.  If no
     *                                page_size is defined but a limit is defined, stream()
     *                                will attempt to read the limit with the most
     *                                efficient page size, i.e. min(limit, 1000)
     *
     * @return Stream stream of results
     */
    public function stream(array $options = [], int $limit = null, $pageSize = null): Stream
    {
        $limits = $this->version->readLimits($limit, $pageSize);

        $page = $this->page($options, $limits['pageSize']);

        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    /**
     * Reads CertificateInstance records from the API as a list.
     * Unlike stream(), this operation is eager and will load `limit` records into
     * memory before returning.
     *
     * @param array|Options $options  Optional Arguments
     * @param int           $limit    Upper limit for the number of records to return. read()
     *                                guarantees to never return more than limit.  Default is no
     *                                limit
     * @param mixed         $pageSize Number of records to fetch per request, when not set
     *                                will use the default value of 50 records.  If no
     *                                page_size is defined but a limit is defined, read()
     *                                will attempt to read the limit with the most
     *                                efficient page size, i.e. min(limit, 1000)
     *
     * @return CertificateInstance[] Array of results
     */
    public function read(array $options = [], int $limit = null, $pageSize = null): array
    {
        return \iterator_to_array($this->stream($options, $limit, $pageSize), false);
    }

    /**
     * Retrieve a single page of CertificateInstance records from the API.
     * Request is executed immediately.
     *
     * @param array|Options $options    Optional Arguments
     * @param mixed         $pageSize   Number of records to return, defaults to 50
     * @param string        $pageToken  PageToken provided by the API
     * @param mixed         $pageNumber Page Number, this value is simply for client state
     *
     * @return CertificatePage Page of CertificateInstance
     */
    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): CertificatePage
    {
        $options = new Values($options);

        $params = Values::of([
            'DeviceSid' => $options['deviceSid'],
            'PageToken' => $pageToken,
            'Page' => $pageNumber,
            'PageSize' => $pageSize,
        ]);

        $response = $this->version->page('GET', $this->uri, $params);

        return new CertificatePage($this->version, $response, $this->solution);
    }

    /**
     * Retrieve a specific page of CertificateInstance records from the API.
     * Request is executed immediately.
     *
     * @param string $targetUrl API-generated URL for the requested results page
     *
     * @return CertificatePage Page of CertificateInstance
     */
    public function getPage(string $targetUrl): CertificatePage
    {
        $response = $this->version->getDomain()->getClient()->request(
            'GET',
            $targetUrl
        );

        return new CertificatePage($this->version, $response, $this->solution);
    }

    /**
     * Constructs a CertificateContext.
     *
     * @param string $sid a string that uniquely identifies the Certificate
     */
    public function getContext(string $sid): CertificateContext
    {
        return new CertificateContext($this->version, $this->solution['fleetSid'], $sid);
    }
}
