Feature: Admin can delete a static page

  Background:
    Given there are users:
      | email             | password    | role  |
      | user@example.com  | usersecret  | user  |
      | admin@example.com | adminsecret | admin |

  Scenario: Normal user cannot delete a static page
    Given I am logged as "user@example.com"
    When I visit "/pages/delete/a_page"
    Then the response status code should be 403

  Scenario: Admin cannot delete a unknown static page
    Given I am logged as "admin@example.com"
    When I visit "/pages/delete/a_page"
    Then the response status code should be 404

  Scenario: Admin deletes a static page
    Given I am logged as "admin@example.com"
    And there are static pages with:
      | title   | content               |
      | Example | This is a static page |
      | Dummy   | This is a dummy page  |
    When I visit "pages/delete/example"
    Then I should be on "/pages/list"
    And I should see "Page successfully deleted"
    And I should see static pages with:
      | title | content              |
      | Dummy | This is a dummy page |