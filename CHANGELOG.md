# Version history

Full changelog for the Costs to Expect web app.

## 2019-08-09 - 1.04.5

* Added `collection` parameter to the subcategories request to override pagination.
* Added `dockerignore` so the build ignores the `vendor` directory.

## 2019-07-10 - v1.04.4

* Updated the `postError` request, sends the `source` field which is required for the API ^=1.16.1. 

## 2019-05-30 - v1.04.3

* Updated FE dependencies, Jquery and Popper.
* Set X-Source request header for API request logging.
* Unable to delete an expense.

## 2019-05-01 - v1.04.2 

* Update app to work with v1.14.1 of the API.

## 2019-04-19 - v1.04.1 

* Child selector on add expense defaults to the `seleced` child.
* On sign-in default to `Jack`.

## 2019-04-11 - v1.04.0 [Final release, now deprecated]

* Added ability to switch between children.
* Removed summary lists, app now deprecated.
* Updated sign-in behaviour, automatically chooses first child in list.

## 2019-04-10 - v1.03.2

* Switched to new API routes.

## 2018-11-20 - v1.03.1

* Removed API category ids from config file, defined in env file.
* Remove database connection details from env.example, no local database.
* Updated API helper, logs an error if an unexpected error code is returned from API.

## 2018-11-05 - v1.03.0

* The filtered expenses view now shows all expenses if less than 50, otherwise the first 50.
* Updated API helper, added the ability to make a HEAD request and pull out headers.
* Updated API helper, added getInstance(), not a correctly implemented singleton. 

## 2018-10-18 - v1.02.3

* Quick hack to remove filtering on filtered lists, default to requesting 50, need to add support for OPTIONS requests.
* Updated API Request helper, added methods to define redirects for request error and client exceptions.
* Recent shows the last 10 expenses entered.
* Minor updates to view files, separate control over navigation and control over add expense button.

## 2018-10-14 - v1.02.2

* Fixed day formatting, no longer display a leading zero on the day.
* Added post support to new Api helper class.
* Added delete support to new Api helper class.
* Added two sub categories, Friend Birthday and Leisure.

## 2018-10-13 - v1.02.1

* Added an Api helper class to handle GET requests to the API.
* Split up the Index controller, actions grouped accordingly.

## 2018-09-30 - v1.02.0

* Added a version history within the app, parses CHANGELOG.
* Added link to personal site.
* Summary tables updated, all now include a link to a filtered list.
* Added an /expenses view, allows filtering by year, month, category and sub category, no UI yet for filtering the list or pagination.

## 2018-09-21 - v1.01.0

* Added years and months summary views.
* Updated the layout of titles.

## 2018-09-20 - v1.00.0

Initial release of the Web app for the Costs to Expect API, allows 
expenses to be added and includes a couple of views to return the data, as more 
features are added to the API the web app will be updated to use them.
