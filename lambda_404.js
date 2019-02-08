const http = require('http');

exports.handler = async (event, context, callback) => 
{
    var response = event.Records[0].cf.response;
    var request  = event.Records[0].cf.request;

    if (response.status >= 400 && response.status <= 599 ) 
    {
        var loader = null;
        if ( request.uri.includes('/espanol/') )
        {
            loader = loadPageBody(event,'/espanol/pagina-error/index.html');
        } else {
            // loader = loadPageBody(event,'/page-error/index.html');
            callback(null, response);
            return;
        }
        var body = await loader;

        response.headers['cache-control'] = [{
            key:   'Cache-Control', 
            value: 'max-age=1'
        }];
        response.headers['content-type'] = [{
            key:   'Content-Type', 
            value: 'text/html'
        }];
        response.headers['content-encoding'] = [{
            key:   'Content-Encoding', 
            value: 'UTF-8'
        }];
        response.body = body;

        callback(null, response);
    } else {
        callback(null, response);
    }
};

const loadPageBody = (event,path) => {
    return new Promise( (resolve,reject) =>
    {
        var config  = event.Records[0].cf.config;

        const req = http.get('http://'+config.distributionDomainName+path, (res) => 
		{
			if (res.statusCode < 200 || res.statusCode >= 300) 
			{
                return reject(new Error('statusCode=' + res.statusCode));
			}
			var body = [];
            res.on('data', chunk => {
                body.push(chunk);
			}).on('end', () => {
                try {
                    body = Buffer.concat(body).toString();
                } catch(e) {
                    reject(e);
                }
                resolve(body);
            });
        }).on('error', (e) => 
		{
            console.error(e);
			reject(e)
        });
        req.end();
    });
};