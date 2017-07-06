/**
 * Open the given URL
 * @param  {String}   type Type of navigation (url or site)
 * @param  {String}   page The URL to navigate to
 * @param  {Function} done Function to execute when finished
 */
module.exports = (type, page, done) => {
    /**
     * The URL to navigate to
     * @type {String}
     */
    const url = (type === 'url') ? page : browser.options.baseUrl + page;
    const supertest = require('supertest');
    const api = supertest(url);

    browser.url(url);
    api.get('/').set('Accept', 'application/json').expect(200, done);
    done();
};
