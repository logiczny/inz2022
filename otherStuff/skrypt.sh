#!/bin/bash
# test api token from wpscan, you can put more here like so: ("1" "2" "3")
apiTokensList="apiKeys.list"
apiToken=${shuf -n 1 ${apiTokensList}}
echo $apiToken;

skanowanie()
(
	if [ "$5" = "-A" ]; then
	wytnijSpam1="Service detection performed. Please report any incorrect results at https://nmap.org/submit/"
	wytnijSpam2="Nmap done: 1 IP address"
	wytnijSpam3="Starting Nmap 7.70 ( https://nmap.org )"
	nmap "$1" -p"$2"-"$3" "$5" --script=default,vuln | grep -v "$wytnijSpam1" | grep -v "$wytnijSpam2" | grep -v "$wytnijSpam3" 2>&1
	fi
	### remember to extend php cli & fpm timeouts, also nginx
	### https://easyengine.io/tutorials/php/increase-script-execution-time/

	IFS=$'\n'; nmapOutput=( $(nmap "$1" -p"$2"-"$3" | grep open) )
	declare -a otwartePorty;
	echo "Znalezione otwarte porty:"

	for i in "${!nmapOutput[@]}"; do
		shortening=$(echo "${nmapOutput[i]}" | sed 's#/.*##g')
		otwartePorty[i]="$shortening";
		echo "${otwartePorty[i]}";
	done

	if [ -n "$otwartePorty" ]; then
		for i in "${otwartePorty[@]}"; do
			echo "WPscan per port starts now";
			wpscan --url http://${1}:${i} -f cli-no-color --api-token ${apiToken} --no-banner --random-user-agent "$4";
			wpscan --url https://${1}:${i} -f cli-no-color --api-token ${apiToken} --no-banner --random-user-agent "$4";
			
		done
	else
		echo "Nothing found, try another ports?"
	fi
)

#echo $5
if [ $# -eq 5 ]; then
echo wejscie w ifa
    skanowanie $1 $2 $3 "$4" "$5"
fi

