<?php

namespace Typedin\LaravelCalendly\Entities\CalendlySubmissionTracking;

class CalendlySubmissionTracking
{
	/**
	 * The UTM parameter used to track a campaign.
	 * @var string|null $utm_campaign
	 */
	public string $utm_campaign;

	/**
	 * The UTM parameter that identifies the source (platform where the traffic originates).
	 * @var string|null $utm_source
	 */
	public string $utm_source;

	/**
	 * The UTM parameter that identifies the type of input (e.g. Cost Per Click (CPC), social media, affiliate or QR code).
	 * @var string|null $utm_medium
	 */
	public string $utm_medium;

	/**
	 * UTM content tracking parameter.
	 * @var string|null $utm_content
	 */
	public string $utm_content;

	/**
	 * The UTM parameter used to track keywords.
	 * @var string|null $utm_term
	 */
	public string $utm_term;

	/**
	 * The Salesforce record unique identifier.
	 * @var string|null $salesforce_uuid
	 */
	public string $salesforce_uuid;


	public function __construct(
		?string $utm_campaign,
		?string $utm_source,
		?string $utm_medium,
		?string $utm_content,
		?string $utm_term,
		?string $salesforce_uuid,
	) {
		$this->utm_campaign = $utm_campaign;
		$this->utm_source = $utm_source;
		$this->utm_medium = $utm_medium;
		$this->utm_content = $utm_content;
		$this->utm_term = $utm_term;
		$this->salesforce_uuid = $salesforce_uuid;
	}
}
