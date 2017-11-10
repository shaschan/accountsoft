//custom directives
//bind-html-compile
fmsApp.directive('bindHtmlCompile', ['$compile', function ($compile) {
    return {
    restrict: 'A',
    link: function (scope, element, attrs) {
      scope.$watch(function () {
            return scope.$eval(attrs.bindHtmlCompile);
        }, function (value) {
                // Incase value is a TrustedValueHolderType, sometimes it
                // needs to be explicitly called into a string in order to
                // get the HTML string.
                element.html(value && value.toString());
                // If scope is provided use it, otherwise use parent scope
                var compileScope = scope;
                if (attrs.bindHtmlScope) {
                    compileScope = scope.$eval(attrs.bindHtmlScope);
                }
                $compile(element.contents())(compileScope);
            });
        }
    };
}]);

//ng-custom-if
fmsApp.directive('ngCustomIf', ['$animate', function($animate) {
  function toBoolean(value) {
    if (typeof value === 'function') {
      value = true;
    } else if (value && value.length !== 0) {
      var v = angular.lowercase("" + value);
      value = !(v == 'f' || v == '0' || v == 'false' || v == 'no' || v == 'n' || v == '[]');
    } else {
      value = false;
    }
    return value;
  };

  function getBlockElements(nodes) {
    var startNode = nodes[0],
        endNode = nodes[nodes.length - 1];
    if (startNode === endNode) {
      return (startNode);
    }

    var element = startNode;
    var elements = [element];

    do {
      element = element.nextSibling;
      if (!element) break;
      elements.push(element);
    } while (element !== endNode);

    return (elements);
  }

  return {
    transclude: 'element',
    priority: 600,
    terminal: true,
    restrict: 'A',
    $$tlb: true,
    link: function ($scope, $element, $attr, ctrl, $transclude) {
        var block, previousElements;
        $scope.$watch($attr.ngCustomIf, function ngCustomIfWatchAction(newValue, oldValue) {

          if (toBoolean(newValue)) {
            if(!previousElements){
              $transclude($scope, function (clone) {
                clone[clone.length] = document.createComment(' end ngCustomIf: ' + $attr.ngCustomIf + ' ');
                clone.length = clone.length + 1;
                block = {
                  clone: clone
                };
                previousElements = clone;
                $animate.enter(clone, $element.parent(), $element);
              });
            }
          } else {
            if(previousElements) {
              $(previousElements).remove();
              previousElements = null;
            }
            if(block) {
              previousElements = getBlockElements(block.clone);
              $(previousElements).remove();
              block = null;
              previousElements = null;
            }
          }
        }, true);
    }
  };
}]);