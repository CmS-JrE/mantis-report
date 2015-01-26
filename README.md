# Mantis Report

Simple PHP code to report issues into Mantis

## Introduction

I had the need for a simple way to allow anonymous reporting of issues into Mantis, a simple form, submit, results.

Many sources point to Anonymantis for this, but it is outdated, not maintained, and the website is even only available anymore in the Wayback Machine.

## Setup

1. Copy the contents of this repository into a folder on your web server
1. Create a user in your Mantis with the appropriate permissions
1. Create a `report.ini` (use `report.ini.default` as a template)
1. Change the "*Category*" `<select>` in `report.html` to represent your relevant categories
1. Browse to `http://... /mantis-report/report.html` and enjoy

## Disclaimer

- This may need some spam protection in the future
- This is the simplest possible solution to the problem, and many thinkable options are not available here
