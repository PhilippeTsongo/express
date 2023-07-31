export class AccessLevelHandler
{
    grant_access(_ACCOUNT_TYPE, _ACCESS_)
    {
        if ( _ACCOUNT_TYPE == 'SUPER_ADMINISTRATOR' ){
			return true;
		}

		if ( _ACCOUNT_TYPE == 'ADMINISTRATOR' ){

			if ( _ACCESS_ == 'MENU_ADMIN' )
				return true;

			if ( _ACCESS_ == 'ADMINISTRATOR_LIST' )
				return true;
			// if ( _ACCESS_ == 'ADMINISTRATOR_REGISTRATION' )
			// 	return true;
			// if ( _ACCESS_ == 'ADMINISTRATOR_EDIT' )
			// 	return true;

			if ( _ACCESS_ == 'CUSTOMER_LIST' )
				return true;
			if ( _ACCESS_ == 'CUSTOMER_REGISTRATION' )
				return true;
			if ( _ACCESS_ == 'CUSTOMER_EDIT' )
				return true;

			if ( _ACCESS_ == 'AGENT_LIST' )
				return true;
			if ( _ACCESS_ == 'AGENT_REGISTRATION' )
				return true;
			if ( _ACCESS_ == 'AGENT_EDIT' )
				return true;

		
			if ( _ACCESS_ == 'PRODUCT_LIST' )
				return true;
			// if ( _ACCESS_ == 'PRODUCT_REGISTRATION' )
			// 	return true;
			// if ( _ACCESS_ == 'PRODUCT_EDIT' )
			// 	return true;

			if ( _ACCESS_ == 'SHOP_LIST' )
				return true;
			// if ( _ACCESS_ == 'SHOP_REGISTRATION' )
			// 	return true;
			// if ( _ACCESS_ == 'SHOP_EDIT' )
			// 	return true;

			if ( _ACCESS_ == 'PAYMENT_LIST' )
				return true;
			if ( _ACCESS_ == 'PAYMENT_REGISTRATION' )
				return true;
			if ( _ACCESS_ == 'PAYMENT_EDIT' )
				return true;
			if ( _ACCESS_ == 'PAYMENT_DELETE' )
				return true;

			if ( _ACCESS_ == 'LIST' )
				return true;
			// if ( _ACCESS_ == 'LIST_ACTION' )
			// 	return true;

			// if ( _ACCESS_ == 'LIST_ACTION_ADMIN' )
			// 	return true;
			if ( _ACCESS_ == 'LIST_ACTION_AGENT' )
				return true;
			if ( _ACCESS_ == 'LIST_ACTION_CUSTOMER' )
				return true;
			if ( _ACCESS_ == 'LIST_ACTION_PRODUCT' )
				return true;
			if ( _ACCESS_ == 'LIST_ACTION_SHOP' )
				return true;

			if ( _ACCESS_ == 'LIST_ACTION_ACTIVATE' )
				return true;
			if ( _ACCESS_ == 'LIST_ACTION_DEACTIVATE' )
				return true;
			if ( _ACCESS_ == 'LIST_ACTION_EDIT' )
				return true;
			if ( _ACCESS_ == 'LIST_ACTION_DELETE' )
				return true;

		}

		if ( _ACCOUNT_TYPE == 'USER' ){

			if ( _ACCESS_ == 'CUSTOMER_LIST' )
				return true;
			if ( _ACCESS_ == 'AGENT_LIST' )
				return true;
			if ( _ACCESS_ == 'PRODUCT_LIST' )
				return true;
			if ( _ACCESS_ == 'SHOP_LIST' )
				return true;
			if ( _ACCESS_ == 'PAYMENT_LIST' )
				return true;

		}

		return false;
    }
}