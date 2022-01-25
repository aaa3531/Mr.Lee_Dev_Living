function kakaolink_send(text, url, img) {
	Kakao.Link.sendScrap({
		requestUrl: url
	});
}