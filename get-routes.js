const https = require("https");
const fs = require('fs')
const yaml = require('js-yaml')

const getArgs = () => process.argv.slice(2)
const splitArgs = (args) =>  args.map(s => s.split(/=(.+)/))
const getArg = (args, arg) => args.find(value => value[0] === arg)
const getArgValue = (arg) => arg[1]
const exists = (val) => !!val
const fileExists = (filename) => fs.existsSync(__dirname + '/' + filename)

const forceUpdate = exists(getArg(splitArgs(getArgs()), '--force'))
const hasExistingRoutes = fileExists('routes.json')

if (!hasExistingRoutes || forceUpdate) {
  process.env.NODE_TLS_REJECT_UNAUTHORIZED = "0";
  const url = getArg(splitArgs(getArgs()), '--url')
  const hasUrl = exists(url)
  const wpConfig = fs.readFileSync(__dirname + '/config.yml');
  const parsedYaml = yaml.safeLoad(wpConfig)
  const defaultBaseUrl = 'https://' + parsedYaml.development.domains[0]
  const defaultEndpointUrl = '/wp-json/wp/v2/pages?per_page=100'
  const defaultUrl = defaultBaseUrl + defaultEndpointUrl
  getRoutes( hasUrl ? getArgValue(url) : defaultUrl)
} else {
  process.exit()
}

function getRoutes(url) {
  https.get(url, (res) => {
    const { statusCode } = res;
    const contentType = res.headers['content-type'];

    let error;
    if (statusCode !== 200) {
      error = new Error('Request Failed.\n' +
                        `Status Code: ${statusCode}`);
    } else if (!/^application\/json/.test(contentType)) {
      error = new Error('Invalid content-type.\n' +
                        `Expected application/json but received ${contentType}`);
    }
    if (error) {
      console.error(error.message);
      // consume response data to free up memory
      res.resume();
      return;
    }

    res.setEncoding('utf8');
    let rawData = '';
    res.on('data', (chunk) => { rawData += chunk; });
    res.on('end', () => {
      try {
        const parsedData = JSON.parse(rawData);
        const links = parsedData.map(data => data.link)
        console.log(links);
        fs.writeFile("./routes.json", JSON.stringify(links, null, 2), (err) => {
          if (err) {
            process.exit(1)
          }
          process.exit()
        })
      } catch (e) {
        console.error(e.message);
      }
    });
  }).on('error', (e) => {
    console.error(`Got error: ${e.message}`);
    process.exit(1)
  });

}

