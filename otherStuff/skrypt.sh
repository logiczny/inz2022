#!/bin/bash
# test api token from wpscan, you can put more here like so: ("1" "2" "3")
apiTokensList="otherStuff/apiKeys.list"
apiTokenChoosed=$(shuf -n 1 "$apiTokensList")

f_scan()
(
	if [ "$5" = "-A" ]; then
	cutSpam1="Service detection performed. Please report any incorrect results at https://nmap.org/submit/"
	cutSpam2="Nmap done: 1 IP address"
	cutSpam3="Starting Nmap 7.70 ( https://nmap.org )"
	nmap "$1" -p"$2"-"$3" "$5" --script=default,vuln | grep -v "$cutSpam1" | grep -v "$cutSpam2" | grep -v "$cutSpam3" 2>&1
	fi
	### remember to extend php cli & fpm timeouts, also nginx
	### https://easyengine.io/tutorials/php/increase-script-execution-time/

	IFS=$'\n'; nmapOutput=( $(nmap "$1" -p"$2"-"$3" | grep open) )
	declare -a openPorts;
	if [ -n "$nmapOutput" ]; then
		echo "--- Open ports found:"
	fi

	for i in "${!nmapOutput[@]}"; do
		shortening=$(echo "${nmapOutput[i]}" | sed 's#/.*##g')
		openPorts[i]="$shortening";
		echo "${openPorts[i]}";
	done

	if [ -n "$openPorts" ]; then
		for i in "${openPorts[@]}"; do
			echo "";
			echo "--- WPscan starts on port ${i} with http:"
			wpscan --url http://${1}:${i} -f cli-no-color --api-token ${apiTokenChoosed} --no-banner --random-user-agent "$4";
			echo "";
			echo "--- WPscan starts on port ${i} with https:"
			wpscan --url https://${1}:${i} -f cli-no-color --api-token ${apiTokenChoosed} --no-banner --random-user-agent "$4";
		done
	else
		echo "--- Nothing found, try another ports?"
	fi
)
echo "--- Scan started for $1"
echo ""
if [ $# -eq 5 ]; then
    f_scan $1 $2 $3 "$4" "$5"
fi

