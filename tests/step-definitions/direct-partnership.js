const { client } = require('nightwatch-cucumber')
const { Given, Then, When } = require('cucumber')
const shared = client.page.shared()
var faker = require('faker/locale/en_GB')
var title = faker.fake("{{name.prefix}}")
var firstname = faker.fake("{{name.firstName}}")
var lastname = faker.fake("{{name.lastName}}")
var postcode = faker.fake("{{address.zipCode}}")
var city = faker.fake("{{address.city}}")
var streetaddress1 = faker.fake("{{address.streetName}}")
var county = faker.fake("{{address.county}}")

When('I complete valid direct partnership application details', function () {
  return shared
  .clickLinkByPureText('Apply for a new partnership')
  .click('#edit-cancel')
  .clickLinkByPureText('Apply for a new partnership')
  .chooseAuthorityIfOptionPresent('input[name="par_data_authority_id"]','City Enforcement Squad')
  .click('#edit-application-type-direct')
  .click('#edit-next')
  .click('#edit-business-eligible-for-partnership')
  .click('#edit-local-authority-suitable-for-nomination')
  .click('#edit-written-summary-agreed')
  .click('#edit-next')
  .waitForElementVisible('.error-summary', 1000)
  .click('#edit-terms-organisation-agreed')
  .click('#edit-business-regulated-by-one-authority-1')
  .click('#edit-next')
  .waitForElementVisible('.error-summary', 1000)
  .assert.containsText('#par-partnership-application-authority-checklist', 'Is this your local authority?')
  .click('#edit-business-regulated-by-one-authority-1')
  .click('#edit-is-local-authority-1')
  .click('#edit-next')
  .assert.containsText('#par-partnership-about','Use this section to give a brief overview of the partnership')
  .setValue('#edit-about-partnership', 'About the partnership detail')
  .click('#edit-next')
});
  
Given('I complete valid organisation details for direct partnership {string}', function (partnershipname) {
  console.log(title,' | ' + firstname,' | '+lastname,' | '+postcode,' | '+city,' | '+streetaddress1,' | '+county)
  return client
  .setValue('#edit-organisation-name',partnershipname)
  .click('#edit-next')
  .click('#edit-next')
  .clearValue('#edit-postcode')
  .clearValue('#edit-address-line1')
  .clearValue('#edit-address-line2')
  .clearValue('#edit-town-city')
  .clearValue('#edit-county')
  .setValue( '#edit-postcode','SE16 4NX')
  .setValue( '#edit-address-line1','1 Change St')
  .setValue( '#edit-address-line2','New Change')
  .setValue( '#edit-town-city','London')
  .setValue( '#edit-county','London')
  .click('#edit-country-code option[value="GB"]')
  .click('#edit-nation option[value="GB-ENG"]')
  .click('#edit-next')
  //  MAIN CONTACT
  .clearValue( '#edit-salutation')
  .clearValue( '#edit-first-name')
  .clearValue( '#edit-last-name')
  .clearValue( '#edit-work-phone')
  .clearValue( '#edit-mobile-phone')
  .clearValue( '#edit-work-phone')
  .clearValue( '#edit-mobile-phone')
  .clearValue( '#edit-email')
  .setValue( '#edit-salutation',title)
  .setValue( '#edit-first-name',firstname)
  .setValue( '#edit-last-name',lastname)
  .setValue( '#edit-work-phone','999999999')
  .setValue( '#edit-mobile-phone','1111111111111')
  .setValue( '#edit-work-phone','02079999999')
  .setValue( '#edit-mobile-phone','078659999999')
  .setValue( '#edit-email','par_business@example.com')
  .click('#edit-preferred-contact-communication-mobile')
  .setValue( '#edit-notes','Some additional notes')
  .click('#edit-next')
});

When('I complete review of the valid direct partnership application', function () {
  return client
    .assert.containsText('h1.heading-xlarge .heading-secondary','New partnership application')
    .assert.containsText('h1.heading-xlarge','Review the partnership summary information below')
    .click('#edit-partnership-info-agreed-authority')
    .click('#edit-save')
}); 

When('the direct partnership creation email template is correct', function () {
 return shared
  .assert.containsText('h1.heading-xlarge .heading-secondary','New partnership application')
  .assert.containsText('h1.heading-xlarge','Notify user of partnership invitation')
  .waitForElementVisible('input[value=\"Invitation to join the Primary Authority Register\"]', 1000)
  .click('#edit-next')
  .assert.containsText('h1.heading-xlarge .heading-secondary','New partnership application')
  .assert.containsText('h1.heading-xlarge','Notification sent')
  .assert.containsText('#block-par-theme-content', title + ' ' + firstname + ' ' + lastname + ' will receive an email with a link to register/login to the PAR website')
  .clickLinkByPureText('Done')
  .assert.containsText('h1.heading-xlarge','Primary Authority Register')
}); 

When('I go to partnership detail page for my partnership {string}', function (partnershipname) {
  return shared
  .clickLinkByPureText('Dashboard')
  .clickLinkByPureText('See your partnerships')
  .click('#edit-partnership-status-1 option[value="confirmed_business"]')
  .setValue('#edit-keywords','Organisation For Direct Partnership')
  .click('#edit-submit-par-user-partnerships')
  .clickLinkByPureText('Organisation For Direct Partnership')
 }); 

 When('I successfully revoke a coordinated partnership', function () {
  return shared
    .clickLinkByPureText('Helpdesk')
    .setValue('#edit-keywords','Specialist Cheesemakers Association')
    .click('#edit-revoked option[value="0"]')
    .click('#edit-submit-helpdesk-dashboard')
    .clickLinkByPureText('Revoke partnership')
    .setValue('#edit-revocation-reason','"A reason for revoking')
    .click('#edit-next')
    .assert.containsText('#edit-partnership-info','The following partnership has been revoked')
    .click('#edit-done')
    .setValue('#edit-keywords','Specialist Cheesemakers Association')
    .click('#edit-revoked option[value="1"]')
    .click('#edit-submit-helpdesk-dashboard')
    .assert.containsText('.table-scroll-wrapper','Specialist Cheesemakers Association')
    .expect.element('#block-par-theme-content > div > div > div > table > tbody > tr:nth-child(2)').to.not.be.present;
});

When('I complete the partnership details for direct partnership {string}', function (partnershipname) {
  return shared
  .clickLinkByPureText('Dashboard')
  .clickLinkByPureText('See your partnerships')
  .setValue('#edit-keywords', partnershipname)
  .click('#edit-partnership-status-1 option[value="confirmed_authority"]')
  .click('#edit-submit-par-user-partnerships')
  .clickLinkByPureText(partnershipname)
   // EDIT ABOUT THE BUSINESS
   .assert.containsText('h1.heading-xlarge','Confirm the details about the organisation')
   .setValue('#edit-about-business','Some information about organisation details')
   .click('#edit-next')
   // EDIT REGISTERED ADDRESS
   .clearValue('#edit-postcode')
   .clearValue('#edit-address-line1')
   .clearValue('#edit-address-line2')
   .clearValue('#edit-town-city')
   .clearValue('#edit-county')
   .assert.containsText('h1.heading-xlarge','Confirm the primary address details')
   .setValue('#edit-postcode','SE16 4NX')
   .setValue('#edit-address-line1','1 High St')
   .setValue('#edit-address-line2','Southwark')
   .setValue('#edit-town-city','London')
   .setValue('#edit-county','London')
   .click('#edit-country-code option[value="GB"]')
   .click('#edit-nation option[value="GB-ENG"]')
   .click('#edit-next')
   .assert.containsText('h1.heading-xlarge','Confirm the primary contact details')
   .click('#edit-next')   
   // ADD SIC CODES
   .click('#edit-sic-code option[value="38"]')
   .click('#edit-next')
   // ADD EMPLOYEES
   .click('#edit-employees-band option[value="250"]')
   .click('#edit-next')   
   // ADD TRADING NAME
   .assert.containsText('h1.heading-xlarge','Confirm the trading name')
   .setValue('#edit-trading-name','Different Trading Name')
   .click('#edit-next')
   // ADD LEGAL ENTITY
   .assert.containsText('h1.heading-xlarge','Confirm the legal entity')
   .setValue('#edit-par-component-legal-entity-0-registered-name', 'New LLP Company')
   .click('#edit-par-component-legal-entity-0-legal-entity-type option[value="limited_liability_partnership"]')
   .assert.containsText('.form-item-par-component-legal-entity-0-registered-number label','Provide the registration number')
   .setValue('#edit-par-component-legal-entity-0-registered-number', '1234567890')
   .click('#edit-add-another')
   .setValue('#edit-par-component-legal-entity-1-registered-name', 'First Sole Trader')
   .click('#edit-par-component-legal-entity-1-legal-entity-type option[value="sole_trader"]')
   .click('#edit-add-another')
   .setValue('#edit-par-component-legal-entity-2-registered-name', 'Second New LLP Company')
   .click('#edit-par-component-legal-entity-2-legal-entity-type option[value="limited_liability_partnership"]')
   .setValue('#edit-par-component-legal-entity-2-registered-number', '0000000000')
   .click('#edit-par-component-legal-entity-2-remove')
   .click('#edit-next')
   // REVIEW PARTNERSHIP
   .assert.containsText('h1.heading-xlarge','Review the partnership summary information below')
   .assert.containsText('#edit-organisation-name',partnershipname)
   .assert.containsText('#edit-organisation-registered-address','1 High St')
   .assert.containsText('#edit-organisation-registered-address','Southwark')
   .assert.containsText('#edit-organisation-registered-address','London')
   .assert.containsText('#edit-organisation-registered-address','SE16 4NX')
   .assert.containsText('#edit-about-organisation','Some information about organisation details')
   .assert.containsText('#edit-sic-code','Social care activities without accommodation')
   .assert.containsText('#edit-legal-entities','New LLP Company')
   .assert.containsText('#edit-legal-entities','Limited Liability Partnership')
   .assert.containsText('#edit-legal-entities','1234567890')
   .assert.containsText('#edit-legal-entities','First Sole Trader')
  //  .expect.element('#edit-legal-entities').text.to.not.contain('Second New LLP Company')
   // CHANGE ABOUT BUSINESS
   .clickLinkByPureText('Change the details about this partnership')
   .assert.containsText('h1.heading-xlarge','Confirm the details about the organisation')
   .setValue('#edit-about-business', 'Change to the information about organisation details')
   .click('#edit-next')   
   .assert.containsText('h1.heading-xlarge','Review the partnership summary information below')
   .assert.containsText('#edit-about-organisation','Change to the information about organisation details')
  //  .expect.element('#edit-about-organisation').text.to.not.contain('Some information about organisation details')
  // CHANGE LEGAL ENTITIES
  .clickLinkByPureText('Change the new legal entities')
  .assert.containsText('h1.heading-xlarge','Confirm the legal entity')
   .click('#edit-par-component-legal-entity-1-remove')
   .setValue('#edit-par-component-legal-entity-0-registered-name','Changed to Public Company')
   .click('#edit-par-component-legal-entity-1-legal-entity-type option[value="public_limited_company"]')
   .assert.containsText('.form-item-par-component-legal-entity-0-registered-number label','Provide the registration number')
   .setValue('#edit-par-component-legal-entity-0-registered-number','55555555558')
   .click('#edit-next')
   .assert.containsText('h1.heading-xlarge','Review the partnership summary information below')
   .assert.containsText('#edit-legal-entities','Changed to Public Company')
   .assert.containsText('#edit-legal-entities','55555555558')
   .click('#edit-save')
   .waitForElementVisible('.error-summary', 2000)
   .click('#edit-partnership-info-agreed-business')
   .click('#edit-save')
   .waitForElementVisible('.error-summary', 1000)
   .click('#edit-terms-organisation-agreed')
   .click('#edit-save')
   .assert.containsText('h1.heading-xlarge','Thank you for completing the application')
   .click('.button')
   .setValue('#edit-keywords',partnershipname)
   .click('#edit-submit-par-user-partnerships')
   .assert.containsText('.table-scroll-wrapper','Confirmed by the Organisation')
 }); 
