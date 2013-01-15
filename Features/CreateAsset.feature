Feature: Create Asset
	In order to have new asset
	As a user
	I need to create an asset

	Scenario: Try to create an asset without logged in
		Given I am on "/admin/asset/new"
		Then I should not see "Assets Management"
	
	@mink:selenium2
	Scenario: Creating an asset after logged in
		Given I am on "/login"
		Then I should see "Login"
		When I fill in "_username" with "admin"
			And I fill in "_password" with "admin"
			And I press "Login"
		Then I go to "/asset"
		Then I should see "Assets Management"
		Then I follow "asset-add-button"
		Then I fill in "asset_name" with "New Asset"
			And I fill in "asset_description" with "New asset description"
			And I fill in "asset_code" with "NEW_ASSET"
			And I select "TEST" from "asset_status"