<?if(!check_bitrix_sessid()) return;
CAdminMessage::showNote(getMessage(toUpper(str_replace('.', '_', getModuleId(__DIR__))) . '_INSTALL_UNSTEP2'))?>