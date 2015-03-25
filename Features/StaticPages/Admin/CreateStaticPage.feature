Feature: Admin can create a new static page

  Background:
    Given there are users:
      | email             | password    | role  |
      | user@example.com  | usersecret  | user  |
      | admin@example.com | adminsecret | admin |

  Scenario: Normal user cannot create a static page
    Given I am logged as "user@example.com"
    When I visit "/pages/add"
    Then the response status code should be 403

  Scenario: Admin can create a static page
    Given I am logged as "admin@example.com"
    When I visit "/pages/add"
    Then I should see the add static page form

  Scenario: Admin cannot create a static page without title
    Given I am logged as "admin@example.com"
    And I am on "/pages/add"
    When I press "Add"
    Then I should be on "/pages/add"
    And I should see "Title required"

  Scenario: Admin creates a static page
    Given I am logged as "admin@example.com"
    And I am on "/pages/add"
    When I fill the page title with "Page title"
    And I fill the page content with "Page content"
    And I press "Add"
    Then I should be on "/pages"
    And I should see static pages with:
      | title      | content      |
      | Page title | Page content |