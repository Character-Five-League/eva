#!/bin/sh

#prepare contast

host='localhost'
port='3306'

warn()
{
	echo >&2 "$(tput bold; tput setaf 1)[!] WARNING: ${*}$(tput sgr0)"
}

# simple error message wrapper
err()
{
	echo >&2 "$(tput bold; tput setaf 1)[-] ERROR: ${*}$(tput sgr0)"

	exit 1337
}

# simple echo wrapper
msg()
{
	echo "$(tput bold; tput setaf 2)[+] ${*}$(tput sgr0)"
}
#welcome screen(tip:if need host set contast host & port)
wel()
{
	whiptail --title "欢迎" --msgbox "欢迎进入本地管理系统\n请在此确认您连接的用户和用户密码\n注意，由于使用的是MariaDB数据库，所以您需要确定您使用的不是MySQL\n而且，您需要确保脚本中开头部分的数据库主机和端口的配置正确" 10 70
}

#test mariadb-status
pre()
{
	tests=`mariadb-admin -h$host -u$user -p$password -P$port ping`
	if [ "$tests" != 'mysqld is alive' ] ; then
		return 0
	else
		return 1
	fi
}

#list user
list()
{
	select="select user_id as 用户序列,uid as 用户识别码,password as 密码明文 from eva.users"
	#res="`mariadb -h$host -u$user -p$password -P$port -t -e "${select}"`"
	whiptail --title "结果" --msgbox "`mariadb -h$host -u$user -p$password -P$port -t -e "${select}"`" --scrolltext 50 110
}

#add administrator
add()
{
	new_user=$(whiptail --title "正在设置用户" --inputbox "请输入用户名\n注意:这里只接受数字" 10 70 3>&1 1>&2 2>&3)
	new_password=$(whiptail --title "正在设置密码" --inputbox "请输入密码" 10 70 3>&1 1>&2 2>&3)
	exitstatus=$?
	if [ $exitstatus = 0 ];then
		fixpwd=$(php -r "echo password_hash('"$new_password"',PASSWORD_DEFAULT);")
		insert="insert into eva.users (user_id,uid,password) values ($new_user,'admin','"$fixpwd"')"
		mariadb -h$host -u$user -p$password -P$port -t -e "${insert}"
		if [ $? -eq 0 ];then
			whiptail --title "结果" --msgbox "操作成功，返回" 10 60
		else
			whiptail --title "结果" --msgbox "操作失败,请确认输入是否正确\n或者排查此用户是否存在" 10 60
			add
		fi
	else
		whiptail --title "结果" --msgbox "您取消了操作，返回" 10 60
	fi
}

#delete user
del()
{
	if (whiptail --title "删除确认" --yesno "确定要删除用户吗？" 10 60);then
		target=$(whiptail --title "正在删除用户" --inputbox "请输入需要删除的用户序列" 10 70 3>&1 1>&2 2>&3)
		exitstatus=$?
		if [ $exitstatus = 0 ];then
			delete="delete from eva.users where user_id = $target"
			mariadb -h$host -u$user -p$password -P$port -t -e "${delete}"
			if [ $? -eq 0 ];then
				whiptail --title "结果" --msgbox "操作成功，返回" 10 60
			else
				whiptail --title "结果" --msgbox "操作失败,请确认输入是否正确\n或者排查此用户是否存在" 10 60
				del
			fi
		else
			whiptail --title "结果" --msgbox "您取消了操作，返回" 10 60
		fi
	else
		whiptail --title "结果" --msgbox "您取消了操作，返回" 10 60
	fi
}

#core
core()
{
	opt=$(whiptail --title "欢迎进入本地管理脚本" --menu --notags "请选择需要的功能" 15 60 4\
		"list" "查看用户列表"\
		"add" "添加管理员用户"\
		"del" "删除管理员用户"\
		"exit" "退出脚本"\
		3>&1 1>&2 2>&3)
	exitstatus=$?
	if [ $exitstatus = 0 ];then
		case $opt in
			"list")
				list
				core
				;;
			"add")
				add
				core
				;;
			"del")
				del
				core
				;;
			"exit")
				msg "感谢使用，在会"
				exit
				;;
		esac
	else 
		msg "您取消了，退出.."
	fi
}

#preset mysql
tml()
{
	user=$(whiptail --title "正在预设置用户" --inputbox "请输入MariaDB的用户名" 10 70 3>&1 1>&2 2>&3)
	password=$(whiptail --title "正在预设置用户密码" --passwordbox "请输入MariaDB用户密码" 10 70 3>&1 1>&2 2>&3)
	exitstatus=$?
	if [ $exitstatus = 0 ];then
		if [ -n "$user" -a  -n "$password" ];then
			pre
			if [ $? -eq 0 ];then
				whiptail --title "结果" --msgbox "连接失败，返回" 10 60
				tml
			else
				whiptail --title "结果" --msgbox "成功，进入菜单" 10 60
			fi
		else
			whiptail --title "结果" --msgbox "输入信息不完善，请重新输入\n请注意，我们不接受无密码登陆" 10 60
			tml
		fi
	else
		err "您取消了输入，退出"
		exit
	fi


}

strap()
{
	wel
	tml
	core
}
strap
