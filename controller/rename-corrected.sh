#!/bin/sh
# ----------------------------------------------------
# @Created: 2017-11-01
# @Author: Wilson Guasca R
# @Description: Tool to easy reconciliation of dev version against releases, and 
#   commit changes locally to git repository.
# ----------------------------------------------------

# ----------------------------------------------------
# Function definitions
# ----------------------------------------------------
# define usage function
usage(){
	echo $'\n'"Usage:  `basename "$0"` param-1 "
	echo "Options:"
	echo "  param-1  Filenames list file"
	echo 
	exit 1
}
# ----------------------------------------------------

echo 
echo \> Running $0

# invoke  usage
# call usage() function if not parameters supplied
[[ $# -lt 1 ]] && usage

# ----------------------------------------------------
JUMP2TARGET=0
TARGET_FOLDER=
INPUT_FILE="$1"

FILES_LIST=`cat "$INPUT_FILE"`

[ "$TARGET_FOLDER" == '.' ] && TARGET_FOLDER=`pwd`

for f in $FILES_LIST; do
	echo File path:$'\t'"$f"

	fname="${f##*/}"
	dname="${f/$fname/}"
	[ -z "$fname" ] && continue 
	#echo "# Add file :"$'\t'$fname
	bname="${fname%-*}.php"
	if [ -f "$f" ]
	then

		echo "[$fname <==> $bname | $dname]"

		mv "${dname}${bname}" "${dname}tmp_${bname}"
		mv "$f" "${dname}${bname}"
		mv "${dname}tmp_${bname}" "$f"

	else
		echo "Not relevant."
	fi

	echo $'\n'
done


[ $JUMP2TARGET -eq 1 ] && cd -

echo

echo ... done.
