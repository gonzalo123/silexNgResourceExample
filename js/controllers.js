function MessageController($scope, Message) {

    var currentResource;
    var resetForm = function () {
        $scope.addMode = true;
        $scope.author = undefined;
        $scope.message = undefined;
        $scope.selectedIndex = undefined;
    }

    $scope.messages = Message.query();
    $scope.addMode = true;

    $scope.add = function () {
        var key = {};
        var value = {author: $scope.author, message: $scope.message}

        Message.save(key, value, function (data) {
            $scope.messages.push(data);
            resetForm();
        });
    };

    $scope.update = function () {
        var key = {id: currentResource.id};
        var value = {author: $scope.author, message: $scope.message}
        Message.save(key, value, function (data) {
            currentResource.author = data.author;
            currentResource.message = data.message;
            resetForm();
        });
    }

    $scope.refresh = function () {
        $scope.messages = Message.query();
        resetForm();
    };

    $scope.deleteMessage = function (index, id) {
        Message.delete({id: id}, function () {
            $scope.messages.splice(index, 1);
            resetForm();
        });
    };

    $scope.selectMessage = function (index) {
        currentResource = $scope.messages[index];
        $scope.addMode = false;
        $scope.author = currentResource.author;
        $scope.message = currentResource.message;
    }

    $scope.cancel = function () {
        resetForm();
    }
}