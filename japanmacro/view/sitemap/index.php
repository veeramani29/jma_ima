<?php 
// make sure that this is the first character in the file, no spaces before it
//print_r($newsContent[0]['post_url']);
$newsContent = $this->resultSet['result']['news'];
$data = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url><loc>https://www.japanmacroadvisors.com/</loc></url>
<url><loc>https://www.japanmacroadvisors.com</loc></url>
<url><loc>https://www.japanmacroadvisors.com/aboutus</loc></url>
<url><loc>https://www.japanmacroadvisors.com/products</loc></url>
<url><loc>https://www.japanmacroadvisors.com/contact</loc></url>
<url><loc>https://www.japanmacroadvisors.com/aboutus/privacypolicy</loc></url>
<url><loc>https://www.japanmacroadvisors.com/aboutus/commercial_policy</loc></url>
<url><loc>https://www.japanmacroadvisors.com/user/login</loc></url>
<url><loc>https://www.japanmacroadvisors.com/user/forgotpassword</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/gdp-and-business-activity/gdp/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/gdp-and-business-activity/corporate-profits/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/gdp-and-business-activity/industrial-production/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/gdp-and-business-activity/machinery-orders/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/gdp-and-business-activity/retail-sales/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/gdp-and-business-activity/number-of-visitors-to-japan/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/international-balance/customs-cleared-trade/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/international-balance/balance-of-payment/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/international-balance/fx-reserve-and-intervention/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/leading-indicators/economy-watchers-survey/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/leading-indicators/tankan/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/leading-indicators/consumer-confidence-index/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/inflation-and-prices/cpi/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/inflation-and-prices/10per-trimmed-cpi/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/inflation-and-prices/cgpi/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/inflation-and-prices/house-price/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/labor-markets/job-offers-to-applicant-ratio/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/labor-markets/unemployment-rate/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/labor-markets/wage-and-hours-worked/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/labor-markets/japan-population/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/labor-markets/tokyo-population/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/financial-markets/exchange-rates/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/financial-markets/interest-rates/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/financial-markets/avg-duration-of-jgbs/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/financial-markets/jgbs-held-by-boj/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/financial-markets/bank-lending/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/balancesheets/general-government/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/balancesheets/household/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/world-economy/long-term-economic-trend/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/prewar-statistics/national-account/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/prewar-statistics/price/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/economic-indicators/prewar-statistics/fx-and-rates/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/bank-of-japan/overview/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/bank-of-japan/what-can-the-boj-do/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/bank-of-japan/boj-policy-meetings/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/bank-of-japan/boj-balance-sheet/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/politics/overview/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/politics/who--s-who/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/politics/cabinet-approval-rating/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/our-views-on-japan/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/special-reports/how-global-is-japan-inc/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/special-reports/abenomics-progress-report/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/special-reports/the-truth-about-tokku-special-zone/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/special-reports/abenomics-nearing-its-expiration-date/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/special-reports/abenomics-is-over/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/page/category/breaking-news/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/materials/category/presentation-materials/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/materials/category/materials-in-japanese/</loc></url>
<url><loc>https://www.japanmacroadvisors.com/user/newsletters</loc></url>
<url><loc>https://www.japanmacroadvisors.com/aboutus/termsofuse</loc></url>
<url><loc>https://www.japanmacroadvisors.com/user/signup</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/bank-of-japan/what-can-the-boj-do/time-for-damage-control</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/bank-of-japan/what-can-the-boj-do/boj-should-twist-and-forward</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/bank-of-japan/boj-policy-meetings/boj-and-its-road-mirage-inflation-target</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/bank-of-japan/boj-policy-meetings/boj-seem-no-longer-bound-by-the-time</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/bank-of-japan/boj-policy-meetings/boj-could-ease-tomorrow</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/bank-of-japan/boj-policy-meetings/why-the-sulky-face-mr-kuroda</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/bank-of-japan/boj-policy-meetings/boj-no-longer-preoccupied-with-the-deflation-risk</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/bank-of-japan/boj-policy-meetings/boj-meeting-on-april-30-2014</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/special-reports/how-global-is-japan-inc/japan-inc.becoming-global-but-not-hollowing-out</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/special-reports/how-global-is-japan-inc/how-global-is-japan-inc</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/special-reports/abenomics-progress-report/abenomics-progress-report-2</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/special-reports/abenomics-progress-report/abenomics-sailing-ahead-but-with-a-risk-of-stagflation</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/special-reports/abenomics-progress-report/abenomics--progress-report</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/end-of-kurodanomics</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/weak-april-machinery-orders-reflect-uncertainly-over-the-future-of-japan</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/wage-growth-remained-stagnant-in-april</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/end-of-abenomics-boom-in-corporate-profits</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/a-false-silver-lining-for-abenomics</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/a-delay-is-not-enough</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/the-man-needs-a-start-over</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/expanding-exports-to-eu-not-enough-to-change-the-tide</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/japan-inc-sees-shrinkage-ahead</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/strong-machinery-orders-due-to-special-oneoff-factor</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/japan-no-longer-on-a-reflation-path</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/boj-opens-the-negative-rate-floodgate</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/market-is-wrong-to-dismiss-the-boj-move-today</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/japan-had-3-recessions-in-the-last-5-years</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/inflation-expectation-fell-to-31-months-low-</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/kuroda-sees-no-need-for-monetary-stimulus</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/japanese-nonmanufacturers-shielded-from-global-uncertainties</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/japan-probably-had-a-technical-recession-in-2015</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/the-august-cpi-data-will-not-push-boj-into-easing</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/net-export-was-probably-a-drag-to-growth-in-julyseptember-</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/low-income-growth-weighing-down-on-consumer-sentiments</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/weak-q2-gdp-shows-the-limit-of-abenomics</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/wage-inflation-in-japan-requires-more-stirring</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/boj-needs-more-robust-growth-to-avoid-qqe3</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/kuroda-emphatically-reaffirms-the-2-inflation-target</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/japanese-exports-held-down-by-sluggish-shipment-to-china</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/weak-tankan-raises-a-question-if-more-easing-is-required</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/a-lukewarm-spring-time-in-japan</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/slowdown-in-china-affecting-japanese-exports</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/the-wage-inflation-has-finally-arrived</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/2015-to-be-the-most-profitable-year-for-japan-inc.</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/japan-to-enjoy-robust-growth-in-2015-2016</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/made-in-japan-again</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/wages-started-to-grow-again-at-the-close-of-2014</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/do-you-hear-this-sound-of-labor-market-tightening</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/japanese-manufacturers-enjoying-double-digits-growth-in-exports</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/japanese-workers-need-to-bargain-harder-for-higher-wages</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/our-views-on-japan-has-changed</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/weak-gdp-growth-a-blessing-for-japan</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/boj-owned-23per-of-the-jgb-market-in-october</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/kuroda-knows-when-to-go-all-in</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/japanese-manufacturers-are-officially-in-recession!</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/japanese-consumers-more-resilient-than-we-thought</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/japanese-exports-grew-in-september-thanks-to-yen-depreciation</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/a-new-hope-for-a-investment-led-growth</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/tankan-shows-a-moderate-dis-inflation-trend</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/consumers-on-its-mend-in-japan</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/the-new-disinflation-trend-should-prompt-the-boj-to-take-action</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/stagnating-imports-suggest-weak-july-september-quarter</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/policy-makers-to-keep-happy-faces-despite-the-unsettling-gdp-number</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/abe-pushes-out-ishiba-to-solidify-his-political-stability</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/another-progress-made-toward-eliminating-deflation</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/data-shows-japan-may-be-in-recession</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/exports-stopped-shrinking-in-july</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/wage-growth-reached-4-years-high</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/the-weak-q2-gdp-and-its-consequences</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/the-vat-shock-still-lingered-in-june</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/no-sign-of-a-return-to-deflation-after-the-vat-hike</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/surprisingly-weak-imports-in-may-suggests-a-deteriorating-economy</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/real-wage-drops-by-3.1per-in-april</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/consumer-behavior-in-2014-virtually-the-same-as-in-1997</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/foreign-visitors-to-japan-doubled-in-the-last-decade</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/the-weakened-economic-activities-shrunk-the-trade-deficit-in-april</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/japan-inc.-shows-stronger-appetite-to-invest-in-japan</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/consumer-sentiment-continued-to-deteriorate-in-april</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/q1-gdp-gives-hope-for-a-sustainable-growth</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/current-account-deficit-hits-another-record</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/able-bodied-becoming-scarce</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/residential-price-index-shows-cooler-climate-for-housing-market</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/wage-growth-continues-to-lag-behind-inflation</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/a-replay-of-1997</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/vat-hike-fully-transferred-in-april</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/japan-clocks-another-super-sized-trade-deficit-in-march</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/diverging-trends-between-land-and-condominium-prices</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/feeling-melancholic-for-abenomics</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/japan-gov.-likely-over-estimates-its-growth</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/a-primer-on-the-new-house-price-index</loc></url>
<url><loc>https://www.japanmacroadvisors.com/reports/view/breaking-news/estimating-the-duration-of-jgbs-held-by-boj</loc></url>';
$data .= '</urlset>';
echo $data;
?>