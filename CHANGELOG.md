# Version history

Full changelog for the Costs to Expect web app.

## 2018-11-xx - v1.03.x

* Removed API category ids from config file, defined in env file.
* Remove database connection details from env.example, no local database.

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
