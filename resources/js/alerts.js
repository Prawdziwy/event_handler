document.addEventListener('DOMContentLoaded', function () {
	const alerts = document.querySelectorAll('.alert');
	alerts.forEach(alert => {
		setTimeout(() => {
			setTimeout(() => {
				alert.remove();
			}, 300);
		}, 50000);
	});
});