Feature: winner

  Scenario Outline: as a httpClient i need to insert a winner
    Given i post metadata <first_name>, <last_name>, <birthday>, <identity>, <city>, <state>
    Then I shoud get a winner from database
    Examples:
      | first_name | last_name | birthday   | identity  | city      | state |
      | John       | Doe       | 1981-05-10 | 409531867 | São Paulo | SP    |

  Scenario: as a httpClient i need to retrieve a winner
    Given A winner id <id>
    Then I should get a winner from database

  Scenario: as a httpClient i need to delete a winner
    Given A winner id <id>
    Then I should delete them from database

  Scenario Outline: as a httpClient i need to update a winner
    Given i put metadata <id>, <first_name>, <last_name>, <birthday>, <identity>, <city>, <state>
    Then I shoud update a winner  from database
    Examples:
      | id | first_name | last_name | birthday   | identity  | city      | state |
      | 1  | John       | Doe       | 1981-05-10 | 409531867 | São Paulo | SP    |