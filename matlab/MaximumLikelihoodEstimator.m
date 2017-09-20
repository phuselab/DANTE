% Finding an optimal estimate of the true emotion based on k evaluators and
% N speech samples tham minimizes the mean square error result in the
% Maximum Likelyhood Estimator (MLE)

function MLE = MaximumLikelihoodEstimator(matriceDati)    
    MLE = sum(transpose(matriceDati))/size(matriceDati, 2);
end

% Each of the evaluators is equally weighted and no a prior knowledge is
% taken into account.
 