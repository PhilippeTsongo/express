export class Hash {
    encryptToken(value) {
        return ( value * value * 422 ) + 20;
    }
    decryptToken(value) {
        return Math.sqrt( (value - 20)/ 422);
    }
    encode(value){
        return btoa ( btoa ( btoa( btoa (value) ) ) );
    }
    decode(value){
        return atob( atob( atob( atob(value) ) ) );
    }
    docdec(value){
		value = value.trim();
		value = atob(value);
		value = atob(value);
		value = atob(value);
		value = value.replaceAll("/", "-"); 
		return value;
	}

}