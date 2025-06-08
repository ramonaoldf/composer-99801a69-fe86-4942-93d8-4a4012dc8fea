<?php namespace Laravel\Cashier;

class LineItem {

	/**
	 * The Stripe invoice line instance.
	 *
	 * @var object
	 */
	protected $stripeLine;

	/**
	 * Create a new line item instance.
	 *
	 * @param  object  $stripeLine
	 * @return void
	 */
	public function __construct($stripeLine)
	{
		$this->stripeLine = $stripeLine;
	}

	/**
	 * Get the total amount for the line item in dollars.
	 *
	 * @return string
	 */
	public function dollars()
	{
		if (starts_with($total = $this->total(), '-'))
		{
			return '-$'.ltrim($total, '-');
		}
		else
		{
			return '$'.$total;
		}
	}

	/**
	 * Get the total for the line item.
	 *
	 * @return float
	 */
	public function total()
	{
		return number_format($this->amount / 100, 2);
	}

	/**
	 * Get a human readable date for the start date.
	 *
	 * @return string
	 */
	public function startDateString()
	{
		if ($this->isSubscription())
		{
			return date('M j, Y', $this->period->start);
		}
	}

	/**
	 * Get a human readable date for the end date.
	 *
	 * @return string
	 */
	public function endDateString()
	{
		if ($this->isSubscription())
		{
			return date('M j, Y', $this->period->end);
		}
	}

	/**
	 * Determine if the line item is for a subscription.
	 *
	 * @return bool
	 */
	public function isSubscription()
	{
		return $this->type == 'subscription';
	}

	/**
	 * Get the Stripe line item instance.
	 *
	 * @return object
	 */
	public function getStripeLine()
	{
		return $this->stripeLine;
	}

	/**
	 * Dynamically access the Stripe line item instance.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->stripeLine->{$key};
	}

	/**
	 * Dynamically set values on the Stripe line item instance.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return mixed
	 */
	public function __set($key, $value)
	{
		$this->stripeLine->{$key} = $value;
	}

}