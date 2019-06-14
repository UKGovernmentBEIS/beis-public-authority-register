Feature: upload advice
As a user
I should be able to upload advice


Scenario: Verify upload advice is  not available for non-active partnerships
Given I am logged in as "par_authority@example.com"
When I click on "See your partnerships"
And I click on "City Enforcement Squad"
And I click "See all Advice"
Then I should see advice page
And I should not see the link "Upload advice"


Scenario: Verify upload advice is available for active partnerships only
Given I am logged in as "par_authority@example.com"
When I click on "See your partnerships"
And I click on "Upper West Side Borough Council"
And I click "See all Advice"
Then I should see advice page
And I see the link "Upload advice"


Scenario: Upload-advice type business
Given I am logged in as "par_authority@example.com"
And I navigate to an active partnership "33968"
When I open advice page
Then I should be able to confirm the guidelines
And I upload the file "files/test.png" to field "#edit-files-upload"
And I click on the button "#edit-upload"
And enter advice title
And I enter summary of advice
And I select advice type "business-advice"
And I select "Cookie control" regulatory function
And I click save
And I see advice uploaded successfully


Scenario: Upload-advice type background information
Given I am logged in as "par_authority@example.com"
And I navigate to an active partnership "33968"
When I open advice page
Then I should be able to confirm the guidelines
And I upload the file "files/test.png" to field "#edit-files-upload"
And I click on the button "#edit-upload"
And enter advice title
And I enter summary of advice
And I select advice type "background-information"
And I select "Cookie control" regulatory function
And I click save
And I see advice uploaded successfully


Scenario: Helpdesk user able to upload advice for an active partnership
Given I am logged in as "par_helpdesk@example.com"
And I navigate to an active partnership "3316"
When I open advice page
Then I should be able to confirm the guidelines
And I upload the file "files/test.png" to field "#edit-files-upload"
And I click on the button "#edit-upload"
And enter advice title
And I enter summary of advice
And I select advice type "business-advice"
And I select "Environmental health" regulatory function
And I click save
And I see advice uploaded successfully


Scenario: Edit advice
Given I am logged in as "par_authority@example.com"
And I navigate to an active partnership "33968"
And I click "See all Advice"
When I click on edit against an advice
And I select file to remove
And I click on the button "#edit-upload"
Then I upload the file "files/Advice Issued - 01 - Attic Descriptions v2_1.pdf" to field "#edit-files-upload"
And I click on the button "#edit-upload"
And I see new file in the advice detail page

@upload-advice
Scenario: Archive advice
Given I am logged in as "par_authority@example.com"
And I navigate to an active partnership "33968"
And I click "See all Advice"
When I click on archive against an advice
When I enter reason "new advice is ready"
And I click save
Then I should archive successfully





Scenario: validate error when guidline checkbox is not selected
Scenario: valdiate error message when title, summary or type of advice
Scenario: Verify search advice
Scenario: Verify filter advice




