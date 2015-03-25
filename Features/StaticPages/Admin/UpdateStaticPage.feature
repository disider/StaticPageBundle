Feature: Admin can update a static page

  Background:
    Given there are users:
      | email             | password    | role  |
      | user@example.com  | usersecret  | user  |
      | admin@example.com | adminsecret | admin |

  Scenario: Normal user cannot update a static page
    Given I am logged as "user@example.com"
    When I visit "/pages/update/a_page"
    Then the response status code should be 403

  Scenario: Admin cannot update a unknown static page
    Given I am logged as "admin@example.com"
    When I visit "/pages/update/a_page"
    Then the response status code should be 404

  Scenario: Admin updates a static page
    Given I am logged as "admin@example.com"
    And there are static pages with:
      | title   | content               |
      | Example | This is a static page |
    When I visit "pages/update/example"
    And I fill the page title with "Another title"
    And I fill the page content with "Another content"
    And I press "Update"
    Then I should be on "/pages/list"
    And I should see "Page successfully updated"
    And I should see static pages with:
      | title         | content         |
      | Another title | Another content |