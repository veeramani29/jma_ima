function parseParam(value) {
  if (value === 'true') {
    value = true;
  } else if (value === 'false') {
    value = false;
  } else if (value === 'null') {
    value = null;
  } else if (value === 'undefined') {
    value = undefined;
  } else if (!isNaN(value) && value !== '') {
    value = parseFloat(value, 10);
  }
  
  return value;
};

function toData(query) {
  var _query = JSON.parse(JSON.stringify(query));
  for (var property in _query) {
    if (_query[property].match(',')) {
      var values = _query[property].split(',');
      _query[property] = values.map(function(value) {
        return parseParam(value);
      });
    } else {
      _query[property] = parseParam(_query[property]);
    }
  }
  return _query;
}

function toQs(query) {
  var _query = JSON.parse(JSON.stringify(query));
  for (var property in _query) {
    if (Array.isArray(_query[property])) {
      _query[property] = _query[property].map(function(value) {
        return String(value);
      });
      _query[property] = _query[property].join(',');
    } else {
      _query[property] = String(_query[property]);
    }
  }
  return _query;
}
var veera=[];

module.exports = {
  toData: toData,
  toQs: toQs,
  veera:veera
};