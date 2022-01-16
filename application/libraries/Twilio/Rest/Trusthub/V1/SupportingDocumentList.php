<?php

declare(strict_types=1);

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0.
 * /       /
 */

namespace Twilio\Rest\Trusthub\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;

class SupportingDocumentList extends ListResource
{
    /**
     * Construct the SupportingDocumentList.
     *
     * @param Version $version Version that contains the resource
     */
    public function __construct(Version $version)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [];

        $this->uri = '/SupportingDocuments';
    }

    /**
     * Provide a friendly representation.
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return '[Twilio.Trusthub.V1.SupportingDocumentList]';
    }

    /**
     * Create the SupportingDocumentInstance.
     *
     * @param string        $friendlyName The string that you assigned to describe the
     *                                    resource
     * @param string        $type         The type of the Supporting Document
     * @param array|Options $options      Optional Arguments
     *
     * @throws TwilioException when an HTTP error occurs
     *
     * @return SupportingDocumentInstance Created SupportingDocumentInstance
     */
    public function create(string $friendlyName, string $type, array $options = []): SupportingDocumentInstance
    {
        $options = new Values($options);

        $data = Values::of([
            'FriendlyName' => $friendlyName,
            'Type' => $type,
            'Attributes' => Serialize::jsonObject($options['attributes']),
        ]);

        $payload = $this->version->create('POST', $this->uri, [], $data);

        return new SupportingDocumentInstance($this->version, $payload);
    }

    /**
     * Streams SupportingDocumentInstance records from the API as a generator
     * stream.
     * This operation lazily loads records as efficiently as possible until the
     * limit
     * is reached.
     * The results are returned as a generator, so this operation is memory
     * efficient.
     *
     * @param int   $limit    Upper limit for the number of records to return. stream()
     *                        guarantees to never return more than limit.  Default is no
     *                        limit
     * @param mixed $pageSize Number of records to fetch per request, when not set
     *                        will use the default value of 50 records.  If no
     *                        page_size is defined but a limit is defined, stream()
     *                        will attempt to read the limit with the most
     *                        efficient page size, i.e. min(limit, 1000)
     *
     * @return Stream stream of results
     */
    public function stream(int $limit = null, $pageSize = null): Stream
    {
        $limits = $this->version->readLimits($limit, $pageSize);

        $page = $this->page($limits['pageSize']);

        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    /**
     * Reads SupportingDocumentInstance records from the API as a list.
     * Unlike stream(), this operation is eager and will load `limit` records into
     * memory before returning.
     *
     * @param int   $limit    Upper limit for the number of records to return. read()
     *                        guarantees to never return more than limit.  Default is no
     *                        limit
     * @param mixed $pageSize Number of records to fetch per request, when not set
     *                        will use the default value of 50 records.  If no
     *                        page_size is defined but a limit is defined, read()
     *                        will attempt to read the limit with the most
     *                        efficient page size, i.e. min(limit, 1000)
     *
     * @return SupportingDocumentInstance[] Array of results
     */
    public function read(int $limit = null, $pageSize = null): array
    {
        return \iterator_to_array($this->stream($limit, $pageSize), false);
    }

    /**
     * Retrieve a single page of SupportingDocumentInstance records from the API.
     * Request is executed immediately.
     *
     * @param mixed  $pageSize   Number of records to return, defaults to 50
     * @param string $pageToken  PageToken provided by the API
     * @param mixed  $pageNumber Page Number, this value is simply for client state
     *
     * @return SupportingDocumentPage Page of SupportingDocumentInstance
     */
    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): SupportingDocumentPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize]);

        $response = $this->version->page('GET', $this->uri, $params);

        return new SupportingDocumentPage($this->version, $response, $this->solution);
    }

    /**
     * Retrieve a specific page of SupportingDocumentInstance records from the API.
     * Request is executed immediately.
     *
     * @param string $targetUrl API-generated URL for the requested results page
     *
     * @return SupportingDocumentPage Page of SupportingDocumentInstance
     */
    public function getPage(string $targetUrl): SupportingDocumentPage
    {
        $response = $this->version->getDomain()->getClient()->request(
            'GET',
            $targetUrl
        );

        return new SupportingDocumentPage($this->version, $response, $this->solution);
    }

    /**
     * Constructs a SupportingDocumentContext.
     *
     * @param string $sid The unique string that identifies the resource
     */
    public function getContext(string $sid): SupportingDocumentContext
    {
        return new SupportingDocumentContext($this->version, $sid);
    }
}
