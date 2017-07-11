#!bin/sh

# e: コマンドが0以外のステータスで終了した場合即座にプログラム終了
# u: 未定義の変数を参照しようとした場合、エラーメッセージを表示する
# x: コマンドと引数の展開を表示する
set -eux

SCRIPT_DIR=$(dirname $(readlink -f $0))
PROJECT_NAME="image_resize"
SETTING_YML=${SCRIPT_DIR}"/docker-compose.yml"

while getopts "f:" OPT
do
    case ${OPT} in
        # 無効なオプションが渡された時
        \?)
            exit;;
        # -fオプションが渡された時
        "f")
            SETTING_YML=${OPTARG}
        ;;
    esac
done

if [ ! -f ${SETTING_YML} ]
then
    echo -e "Not Found yml file"
    exit 1;
fi

COMMAND="up -d --allow-insecure-ssl"
if [ $# -ge 1 ] && [ ! -z "$*" ]
then
    COMMAND="$*"
fi

sudo mkdir -p /data/log/mysql
sudo mkdir -p /data/log/nginx
sudo mkdir -p /data/log/image_resize

sudo chmod 777 /data/log/mysql
sudo chmod 777 /data/log/nginx
sudo chmod 777 /data/log/image_resize

sudo chown www-data:www-data -R ${SCRIPT_DIR}"/../"

docker-compose -f ${SETTING_YML} -p ${PROJECT_NAME} ${COMMAND}

docker ps
