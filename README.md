# PHP-email-google-search-crawl

## Class Feature
- Researching Tool That Can Be Used in B2B Business To Get Business Information Easily!
- Get E-mail Address from Website.
- Get Phone Number from Website.
- Get Facebook Page from Website.
- Get Linkedin Page from Website.
- Search URLs from Google Website.

## Why You Might Need It
Looking for other business is too time consuming job. This should be done with a simple function!

Test yourself and see how you can use it for your business.

## License
You can modify and use it for your benefit! Just refer me!

## Installation
Library:
- crawl.php - Contains the functions to crawl through websites and harvest e-mail, phone number, facebook page, and linkedin page.
- simple_html_dom.php - Simple_html_dom html library. You can find more information here: http://simplehtmldom.sourceforge.net/.

Just add the libraries (files) in your server and include the crawl.php in your project!

## Functions

### email_crawl($URL, &$email, &$phone, &$facebook, &$linkedin);
- $URL        => [input variable]. Insert the URL that you want to crawl. ex) http://example.com
- $email      => [Reference Array]. Just put declare an array and pass the reference to the function to get e-mail addresses.
- $phone      => [Reference Array]. Just put declare an array and pass the reference to the function to get phone numbers.
- $facebook   => [Reference Array]. Just put declare an array and pass the reference to the function to get facebook page(s).
- $linkedin   => [Reference Array]. Just put declare an array and pass the reference to the function to get linkedin page(s).

### google_crawl($keyword, $start, $end, &$url_array = null, &$page_array = null, &$title_array = null);
- $keyword      => [input variable]. Keyword that you want to search in Google. ex) Boolid
- $start        => [input variable]. Start Page of google. ex) 1
- $end          => [input variable]. End Page of google. ex) 5
- $url_array    => [Reference Array]. Just put declare an array and pass the reference to the function to get URLs.
- $page_array   => [Reference Array]. Just put declare an array and pass the reference to the function to get URLs' Page numbers.
- $title_array  => [Reference Array]. Just put declare an array and pass the reference to the function to get URLs' Title.

## A Simple Example
Take a look at example.php! If you have any question, just ask me!


