<?php
App::uses('AppModel', 'Model');
/**
 * group_access表模型
 *
 * @copyright WechatAdmin
 * @package   app.Model
 * @author    Will.Lee <im.will.lee@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class GroupAccess extends AppModel {

/**
 * belongsTo 关系定义
 * @var array
 */
	public $belongsTo = array(
		'MenuAction' => array(
			'className' => 'MenuAction',
			'foreignKey' => 'menu_action_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * 用户组访问权限链接
 * 
 * @param integer $groupId 用户组ID
 * @return array
 */
	public function getUserGroupAccess($groupId) {
		if ($groupId == Configure::read('Group.supper_id')) {
			return array();
		}
		$access = array();
		$options = array(
			'conditions' => array('GroupAccess.group_id' => $groupId),
			'contain' => array('MenuAction')
		);
		$actions = $this->find('all', $options);
		foreach ($actions as $action) {
			$access[] = $action['MenuAction']['link'];
		}
		unset($options, $actions);
		return $access;
	}

/**
 * 用户组访问权限ID
 * 绑定checkbox
 * 
 * @param integer $groupId 用户组ID
 * @return array
 */
	public function getGroupAccessForCheckbox($groupId) {
		if ($groupId == Configure::read('Group.supper_id')) {
			return array();
		}
		$access = array();
		$options = array(
			'conditions' => array('GroupAccess.group_id' => $groupId),
			'contain' => false
		);
		$actions = $this->find('all', $options);
		foreach ($actions as $action) {
			$access[$action['GroupAccess']['menu_action_id']] = $action['GroupAccess'];
		}
		unset($options, $actions);
		return $access;
	}
}
