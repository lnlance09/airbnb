<?php
	require_once("airbnb.php");

	// Call a new instance of AirBnB
	$airbnb = new AirBnB;

	// Get the OAuth token
	$token = $airbnb->Authorize('email', 'password');

	// Search listings
	$data = array(
				'location' => 'New York, NY, United States',
				'user_lng' => -73.98530667330833,
				'user_lat' => 40.75268419028417,
				'currency' => 'USD',
				'ib' => TRUE,
				'ib_add_photo_flow' => TRUE,
				'suppress_facets' => TRUE,
				'room_types[]' => 'private_room',
				'room_types[]' => 'shared_room',
				'room_types[]' => 'entire_home',
				'amenities[]' => 1,
				'amenities[]' => 2,
				'amenities[]' => 3,
				'price_min'	=> 267,
				'price_max' => 872,
				'checkin' => '2015-12-29',
				'checkout' => '2016-01-19',
				'guests' => 2,
				'sort' => 0,
				'_offset' => 0,
				'_format' => 'for_search_results_with_minimal_pricing',
				'_limit' => 20,
				'min_num_pic_urls' => 10,
				);
	$listings = $airbnb->SearchListings($data, NULL);

	echo '<pre>';
	print_r($listings);
	echo '</pre>';

	/*
	// Create a listing
	$data = array(
				"room_type_category" => "private_room",
				"min_nights" => 0,
				"tracking_id" => "",
				"country" => "United States",
				"price_for_extra_person_native" => 0,
				"state" => "NY",
				"weekly_price_factor" => 0,
				"check_out_time" => 0,
				"listing_status_string" => "Unlisted",
				"instant_book_lead_time_hours" => 0,
				"cancel_policy" => 0,
				"beds" => 1,
				"cleaning_fee_native" => 0,
				"listing_weekend_price_native" => 0,
				"person_capacity" => 2,
				"listing_price_for_extra_person_native" => 0,
				"listing_security_deposit_native" => 0,
				"weekly_price_native" => 0,
				"guests_included" => 0,
				"bedrooms" => 1,
				"picture_count" => 0,
				"monthly_price_native" => 0,
				"bathrooms" => 1,
				"reviews_count" => 0,
				"listing_weekly_price_native" => 0,
				"check_in_time" => 0,
				"property_type_id" => 1,
				"monthly_price_factor" => 0,
				"price_native" => 0,
				"star_rating" => 0,
				"lng" => -73.98516412028782,
				"city" => "New York",
				"listing_monthly_price_native" => 0,
				"debug_description" => "BBListing <(null) = (null)>",
				"listing_price_native" => 0,
				"listing_cleaning_fee_native" => 0,
				"lat" => 40.752592783415558,
				"country_code" => "US",
				"max_nights" => 0,
				"square_feet" => 0,
				"photos" => [],
				"security_price_native" => 0,
				"extras_price_native" => 0,
				"weekend_price_native" => 0
				);
	$listing = CreateListing($data, $token);
	*/
?>