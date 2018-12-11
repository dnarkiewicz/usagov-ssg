/* Public domain project by Cloud Under (https://cloudunder.io).
 * Repository: https://github.com/CloudUnder/lambda-edge-nice-urls
 */

const config = {
	suffix: '.html',
	appendToDirs: 'index.html',
	removeTrailingSlash: false,
};

const regexSuffixless = /\/[^/.]+$/; // e.g. "/some/page" but not "/", "/some/" or "/some.jpg"
const regexTrailingSlash = /.+\/$/; // e.g. "/some/" or "/some/page/" but not root "/"

exports.handler = function handler(event, context, callback) {
	const { request } = event.Records[0].cf;
	const { uri } = request;
	const { suffix, appendToDirs, removeTrailingSlash } = config;

	// request.uri = request.uri.toLowerCase();

	// Append ".html" to origin request
	if (suffix && uri.match(regexSuffixless)) {
		request.uri = uri + suffix;
		callback(null, request);
		return;
	}
	
	// Append "index.html" to origin request
	if (appendToDirs && uri.match(regexTrailingSlash)) {
		request.uri = uri + appendToDirs;
		callback(null, request);
		return;
	}

	// Redirect (301) non-root requests ending in "/" to URI without trailing slash
	if (removeTrailingSlash && uri.match(/.+\/$/)) {
		const response = {
			// body: '',
			// bodyEncoding: 'text',
			headers: {
				'location': [{
					key: 'Location',
					value: uri.slice(0, -1)
				 }]
			},
			status: '301',
			statusDescription: 'Moved Permanently'
		};
		callback(null, response);
		return;
	}

	// If nothing matches, return request unchanged
	callback(null, request);
};


//// possible page respose rewrite

'use strict';

exports.handler = (event, context, callback) => {
    const response = event.Records[0].cf.response;
    const request = event.Records[0].cf.request;

    /**
     * This function updates the HTTP status code in the response to 302, to redirect to another
     * path (cache behavior) that has a different origin configured. Note the following:
     * 1. The function is triggered in an origin response
     * 2. The response status from the origin server is an error status code (4xx or 5xx)
     */

    if (response.status >= 400 && response.status <= 599) {
        const redirect_path = `/plan-b/path?${request.querystring}`;

        response.status = 302;
        response.statusDescription = 'Found';

        /* Drop the body, as it is not required for redirects */
        response.body = '';
        response.headers['location'] = [{ key: 'Location', value: redirect_path }];
    }

    callback(null, response);
};
