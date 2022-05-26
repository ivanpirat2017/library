let url = window.location.origin + '/api';

export const LOGIN = url + '/login';
export const REGISTER = url + '/register';
export const LOGOUT = url + '/logout';
export const GET_TOKENS = url + '/gettokens';


export const BOOK_UPDATE = url + '/bookupdate';

export const GET_ALL_GENRES = url + '/getgenres';
export const GET_GENRE = url + '/getgenre/';

export const GET_AWARD = url + '/award/';

export const  GET_AWARDS = url + '/getawards';

export const GET_GENRE_BOOK_ID = url + '/getbookid/';
export const GET_GENRE_BOOKS = url + '/getgenrebooks/';
export const GET_NEW_BOOKS = url + '/getnewbooks';
export const GET_POPULAR_BOOKS = url + '/getpopularbooks';
export const SEARCH_BOOK = url + '/searchbook?query=';
export const FAVOURITES = url + '/favourites';

export const AUTH_CHECK = url + '/authcheck';
export const AUTH_ADMIN_CHECK = url + '/authadmincheck';


export const GET_COMMENT_BOOK_ID = url + '/getcommentbook/';
export const ADD_COMMENT = url + '/addcoment';

export const LIKE_COMENT = url + '/likecoment';

export const GET_ACTION = url + '/getaction';
export const GET_ACTION_ID = url + '/getactionid/';

export const GET_PROFILE = url + '/getprofile';
export const GET_USER = url + '/getuser/';
export const UPDATE_PROFILE = url + '/updateprofile';

export const CREATR_COLLECTION = url + '/creatrCollection';
export const GET_COLLECTION = url + '/getcollection';
export const DELL_COLLECTION = url + '/dellCollection/';


export const DELETE_BOOK = url + '/deletebooks/';
export const CREATE_BOOKS = url + '/createbook';
export const CREATE_GENRE = url + '/creategenre';
export const CREATE_STARUS = url + '/createstatus';
export const GET_STARUSES = url + '/getstatus';
export const GET_BOOK_PARSER = url + '/getbookparser';
export const CREATE_ACTION= url + '/createaction';

export const ADD_WATCH_BOOK= url + '/addwatchbook/';

export const DOUMLONDDOOK= url + '/doumlonddook/';

export const ADD_MESSAGE= url + '/addmessage';
export const GET_MESSAGES= url + '/getmessages/';


export const GET_COMMENT_ADMIN= url + '/getcommentadmin/';
export const UPDATA_COMMENT_ADMIN= url + '/updatacommentadmin';
export async function authCheck() {
    return await fetch(AUTH_CHECK, {
        method: 'GET',
        headers: {
            "Authorization": 'Bearer ' + localStorage.getItem('token')
        }
    }).then(r => { return r });
}
export async function authAdminCheck() {
    return await fetch(AUTH_ADMIN_CHECK, {
        method: 'GET',
        headers: {
            "Authorization": 'Bearer ' + localStorage.getItem('token')
        }
    }).then(r => { return r });
}




export async function getApi(url, obj = { method: "GET" }) {
    const data = await fetch(url, obj).then(r => r.json()).then(r => { return r });
    return data;
}
