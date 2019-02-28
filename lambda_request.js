/* Public domain project by Cloud Under (https://cloudunder.io).
 * Repository: https://github.com/CloudUnder/lambda-edge-nice-urls
 */

const config = {
	suffix: '/index.html',
	appendToDirs: 'index.html',
	removeTrailingSlash: false,
	redirectCaseSensitive: false,
};

// e.g. "/some/page" but not "/", "/some/" or "/some.jpg"
const regexSuffixless = /\/[^/.]+$/;

// e.g. "/some/" or "/some/page/" but not root "/"
const regexTrailingSlash = /.+\/$/;

// e.g. begins with a certain directory
const regexCaseSensitive = /^\/?(css|fonts|images|js|sites|explorer|explorar|analytics)(\/|$)/i;

exports.handler = function handler(event, context, callback) {
	const { request } = event.Records[0].cf;

	/// Lowercase the uri to match backend (where most paths are lowercase)
	if ( ! request.uri.match(regexCaseSensitive) )
	{
		var lowerCaseUri = request.uri.toLowerCase();
		if ( request.uri != lowerCaseUri )
		{
			if ( config.redirectCaseSensitive )
			{
				/// send a redirect to the lowercased uri
				const response = {
					headers: {
						'location': [{
							key: 'Location',
							value: lowerCaseUri
						}]
					},
					status: '302',
					statusDescription: 'Moved Temporarily'
				};
				callback(null, response);
				return;
			} else {
				/// continue on internally with the lowercased uri
				request.uri = lowerCaseUri;
			}
		}
	}

	// Append suffix to origin request
	if (config.suffix && request.uri.match(regexSuffixless)) 
	{
		request.uri = request.uri + config.suffix;
		callback(null, request);
		return;
	}

	// Append directory suffix to origin directory request
	if (config.appendToDirs && request.uri.match(regexTrailingSlash)) 
	{
		request.uri = request.uri + config.appendToDirs;
		callback(null, request);
		return;
	}

	// Redirect (301) non-root requests ending in "/" to URI without trailing slash
	if (config.removeTrailingSlash && request.uri.match(/.+\/$/)) 
	{
		const response = {
			// body: '',
			// bodyEncoding: 'text',
			headers: {
				'location': [{
					key: 'Location',
					value: request.uri.slice(0, -1)
				 }]
			},
			status: '301',
			statusDescription: 'Moved Permanently'
		};
		callback(null, response);
		return;
	}

	callback(null, request);
};
