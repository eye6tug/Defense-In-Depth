#!/bin/bash

DATE=$(date '+%Y-%m-%d %H:%M:%S')
echo "============================================="
echo "[$DATE] CHECKING FOR PACKAGE UPDATES..." >> update_log

# specify the log file
LOG_FILE="update_log"

echo "Updating package index..."

sudo apt-get update > /dev/null

# Get a list of all installed packages

INSTALLED_PACKAGES=$(dpkg -l | grep '^ii' | awk '{print $2}')

# Check each installed package for updates

for PACKAGE in $INSTALLED_PACKAGES; do
	echo "Checking $PACKAGE.."
	# Check if an update is available for the package
	AVAILABLE_VERSION=$(apt-cache policy $PACKAGE | grep -i "candidate" | awk '{print $2}')
	INSTALLED_VERSION=$(dpkg -s $PACKAGE |grep -i "version" | awk '{print $2}')
	if [ "$AVAILABLE_VERSION" != "$INSTALLED_VERSION" ]; then
		echo "Update available for $PACKAGE. Installing the latest version..."
		sudo apt-get install -y $PACKAGE
		echo "$(date): $PACKAGE was update to version $AVAILABLE_VERSION from $INSTALLED_VERSION"  >> $LOG_FILE
	else
		echo "$(date): $PACKAGE is already up-to-date" >> $LOG_FILE
	fi
done

echo "============================================"
echo "Script Ended"
